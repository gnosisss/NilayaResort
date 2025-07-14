<?php

namespace App\Http\Controllers;

use App\Models\CheckoutTransaction;
use App\Models\PaymentTransaction;
use App\Services\Midtrans\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    protected $midtransService;
    
    /**
     * Create a new controller instance.
     *
     * @param MidtransService $midtransService
     * @return void
     */
    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }
    
    /**
     * Display the payment form for a checkout transaction.
     */
    public function showPaymentForm($transactionId)
    {
        $checkoutTransaction = CheckoutTransaction::with(['booking', 'user', 'paymentTransactions'])
            ->findOrFail($transactionId);
            
        // Check if the transaction belongs to the authenticated user
        if (Auth::id() !== $checkoutTransaction->user_id) {
            return redirect('/')->with('error', 'Unauthorized access');
        }
        
        return view('payments.form', [
            'transaction' => $checkoutTransaction,
        ]);
    }
    
    /**
     * Process a new payment for a checkout transaction.
     */
    public function processPayment(Request $request, $transactionId)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:cash,credit_card,bank_transfer,e_wallet',
            'payment_proof' => 'required_unless:payment_method,cash|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'payment_notes' => 'nullable|string|max:500',
        ]);
        
        $checkoutTransaction = CheckoutTransaction::findOrFail($transactionId);
        
        // Check if the transaction belongs to the authenticated user
        if (Auth::id() !== $checkoutTransaction->user_id) {
            return redirect('/')->with('error', 'Unauthorized access');
        }
        
        // Check if the payment amount is valid
        if ($request->amount > $checkoutTransaction->remaining_balance) {
            return back()->with('error', 'Payment amount exceeds the remaining balance')->withInput();
        }
        
        // Handle file upload if payment proof is provided
        $paymentProofPath = null;
        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $paymentProofPath = $file->storeAs('payment_proofs', $fileName, 'public');
        }
        
        // Create the payment transaction
        $payment = PaymentTransaction::create([
            'transaction_id' => $checkoutTransaction->transaction_id,
            'user_id' => Auth::id(),
            'payment_code' => 'PAY-' . strtoupper(Str::random(10)),
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'payment_status' => $request->payment_method === 'cash' ? 'completed' : 'pending',
            'payment_proof' => $paymentProofPath,
            'payment_notes' => $request->payment_notes,
            'payment_date' => now(),
        ]);
        
        // Update checkout transaction status if fully paid
        if ($checkoutTransaction->isFullyPaid()) {
            $checkoutTransaction->update([
                'payment_status' => 'paid',
            ]);
        }
        
        return redirect()->route('payments.success', $payment->payment_id)
            ->with('success', 'Payment has been processed successfully');
    }
    
    /**
     * Display payment success page.
     */
    public function showPaymentSuccess($paymentId)
    {
        $payment = PaymentTransaction::with('checkoutTransaction')
            ->findOrFail($paymentId);
            
        // Check if the payment belongs to the authenticated user
        if (Auth::id() !== $payment->user_id) {
            return redirect('/')->with('error', 'Unauthorized access');
        }
        
        return view('payments.success', [
            'payment' => $payment,
        ]);
    }
    
    /**
     * Display payment history for a user.
     */
    public function showPaymentHistory()
    {
        $payments = PaymentTransaction::with('checkoutTransaction')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('payments.history', [
            'payments' => $payments,
        ]);
    }
    
    /**
     * Initiate Midtrans payment for a checkout transaction.
     *
     * @param string $transactionId
     * @return \Illuminate\Http\Response
     */
    public function initiateMidtransPayment($transactionId)
    {
        $checkoutTransaction = CheckoutTransaction::findOrFail($transactionId);
        
        // Check if the transaction belongs to the authenticated user
        if (Auth::id() !== $checkoutTransaction->user_id) {
            return redirect('/')->with('error', 'Unauthorized access');
        }
        
        // Check if the transaction is already fully paid
        if ($checkoutTransaction->isFullyPaid()) {
            return redirect()->route('payments.success', $checkoutTransaction->transaction_id)
                ->with('info', 'This transaction has already been fully paid.');
        }
        
        try {
            // Get Snap Token from Midtrans Service
            $snapToken = $this->midtransService->getSnapToken($checkoutTransaction);
            
            if (!$snapToken) {
                return redirect()->route('payments.form', $checkoutTransaction->transaction_id)
                    ->with('error', 'Failed to generate payment token. Please try again later.');
            }
            
            return view('payments.midtrans', [
                'transaction' => $checkoutTransaction,
                'snap_token' => $snapToken,
                'client_key' => config('midtrans.client_key'),
            ]);
        } catch (\Exception $e) {
            return redirect()->route('payments.form', $checkoutTransaction->transaction_id)
                ->with('error', 'Payment gateway error: ' . $e->getMessage());
        }
    }
}