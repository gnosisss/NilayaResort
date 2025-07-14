<?php

namespace App\Http\Controllers;

use App\Models\CheckoutTransaction;
use App\Models\PaymentTransaction;
use App\Services\Midtrans\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
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
     * Generate Snap Token for a transaction (API endpoint)
     *
     * @param Request $request
     * @param string $transactionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSnapToken(Request $request, $transactionId)
    {
        try {
            $transaction = CheckoutTransaction::findOrFail($transactionId);
            
            // Check if the transaction belongs to the authenticated user
            if (Auth::id() !== $transaction->user_id) {
                return response()->json(['error' => 'Unauthorized access'], 403);
            }
            
            // Check if the transaction is already fully paid
            if ($transaction->isFullyPaid()) {
                return response()->json(['error' => 'Transaction is already fully paid'], 400);
            }
            
            $snapToken = $this->midtransService->getSnapToken($transaction);
            
            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
            ]);
        } catch (\Exception $e) {
            Log::error('Midtrans Get Snap Token Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate payment token: ' . $e->getMessage(),
            ], 500);
        }
    }
    
    /**
     * Generate Snap Token and render Midtrans payment page
     *
     * @param Request $request
     * @param string $transactionId
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function generateSnapToken(Request $request, $transactionId)
    {
        try {
            $transaction = CheckoutTransaction::findOrFail($transactionId);
            
            // Check if the transaction belongs to the authenticated user
            if (Auth::id() !== $transaction->user_id) {
                return redirect()->route('dashboard')
                    ->with('error', 'You are not authorized to access this transaction.');
            }
            
            // Check if the transaction is already fully paid
            if ($transaction->isFullyPaid()) {
                return redirect()->route('payments.success', $transaction->transaction_id)
                    ->with('info', 'This transaction has already been fully paid.');
            }
            
            // Generate Snap Token
            $snapToken = $this->midtransService->getSnapToken($transaction);
            
            if (!$snapToken) {
                return redirect()->route('payments.form', $transaction->transaction_id)
                    ->with('error', 'Failed to generate payment token. Please try again later.');
            }
            
            return view('payments.midtrans', [
                'transaction' => $transaction,
                'snap_token' => $snapToken,
                'client_key' => config('midtrans.client_key')
            ]);
        } catch (\Exception $e) {
            Log::error('Midtrans token generation error: ' . $e->getMessage());
            return redirect()->route('payments.form', $transactionId)
                ->with('error', 'An error occurred while processing your payment. Please try again later.');
        }
    }
    
    /**
     * Handle notification from Midtrans
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function notification(Request $request)
    {
        try {
            $notificationData = $request->all();
            Log::info('Midtrans Notification Received: ' . json_encode($notificationData));
            
            $result = $this->midtransService->handleNotification($notificationData);
            
            if (!$result) {
                return response('Payment notification failed', 500);
            }
            
            return response('OK', 200);
        } catch (\Exception $e) {
            Log::error('Midtrans Notification Error: ' . $e->getMessage());
            return response('Error: ' . $e->getMessage(), 500);
        }
    }
    
    /**
     * Handle finish redirect from Midtrans
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function finish(Request $request)
    {
        Log::info('Midtrans Finish: ' . json_encode($request->all()));
        
        $orderId = $request->order_id;
        $status = $request->transaction_status;
        
        // Find the transaction by order ID
        $transaction = CheckoutTransaction::where('transaction_code', $orderId)->first();
        
        if (!$transaction) {
            return redirect()->route('dashboard')
                ->with('error', 'Transaction not found');
        }
        
        if ($status == 'settlement' || $status == 'capture') {
            // Update payment status to completed
            $paymentTransaction = new PaymentTransaction([
                'transaction_id' => $transaction->transaction_id,
                'user_id' => $transaction->user_id,
                'payment_code' => $transaction->transaction_code,
                'payment_method' => 'midtrans',
                'amount' => $transaction->total_amount,
                'payment_date' => now(),
                'payment_status' => 'completed',
                'payment_details' => json_encode($request->all()),
            ]);
            $paymentTransaction->save();
            
            // Update checkout transaction status if fully paid
            if ($transaction->is_fully_paid) {
                $transaction->update([
                    'payment_status' => 'paid',
                ]);
                
                // Update booking status to confirmed
                $booking = $transaction->booking;
                if ($booking) {
                    $booking->update([
                        'status' => 'confirmed'
                    ]);
                }
            }
            
            return redirect()->route('transactions.show', ['transaction' => $transaction->transaction_code])
                ->with('success', 'Payment completed successfully');
        } else {
            return redirect()->route('payments.form', $transaction->transaction_id)
                ->with('info', 'Payment is being processed. Please check your payment status later.');
        }
    }
    
    /**
     * Handle unfinish redirect from Midtrans
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unfinish(Request $request)
    {
        Log::info('Midtrans Unfinish: ' . json_encode($request->all()));
        
        $orderId = $request->order_id;
        
        // Find the transaction by order ID
        $transaction = CheckoutTransaction::where('transaction_code', $orderId)->first();
        
        if (!$transaction) {
            return redirect()->route('dashboard')
                ->with('error', 'Transaction not found');
        }
        
        return redirect()->route('payments.form', $transaction->transaction_id)
            ->with('warning', 'Payment process was not completed. Please try again.');
    }
    
    /**
     * Handle error redirect from Midtrans
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function error(Request $request)
    {
        Log::info('Midtrans Error: ' . json_encode($request->all()));
        
        $orderId = $request->order_id;
        
        // Find the transaction by order ID
        $transaction = CheckoutTransaction::where('transaction_code', $orderId)->first();
        
        if (!$transaction) {
            return redirect()->route('dashboard')
                ->with('error', 'Transaction not found');
        }
        
        return redirect()->route('payments.form', $transaction->transaction_id)
            ->with('error', 'Payment failed. Please try again or choose another payment method.');
    }
}