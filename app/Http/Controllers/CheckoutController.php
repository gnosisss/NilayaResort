<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\CheckoutTransaction;
use App\Models\CheckoutTransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page for a booking.
     */
    public function checkout(Booking $booking)
    {
        // Check if the authenticated user owns this booking
        if (Auth::id() !== $booking->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        // Check if booking is in a valid state for checkout
        if (!in_array($booking->status, ['confirmed', 'pending'])) {
            return redirect()->route('bookings.show', $booking->booking_id)
                ->withErrors(['status' => 'This booking cannot be checked out.']);
        }
        
        // Calculate total nights and amount
        $nights = $booking->start_date->diffInDays($booking->end_date);
        $pricePerNight = $booking->rentalUnit->price_per_night;
        $totalAmount = $nights * $pricePerNight;
        
        // Get all active checklist items for potential damage assessment
        $checklistItems = \App\Models\Checklist::where('is_active', true)->get();
        
        return view('bookings.checkout', compact('booking', 'nights', 'pricePerNight', 'totalAmount', 'checklistItems'));
    }
    
    /**
     * Process the checkout for a booking.
     */
    public function processCheckout(Request $request, Booking $booking)
    {
        // Check if the authenticated user owns this booking
        if (Auth::id() !== $booking->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        // Validate the request
        $validated = $request->validate([
            'payment_method' => 'required|string|in:cash,credit_card,bank_transfer,e_wallet',
            'notes' => 'nullable|string|max:500',
            'damaged_items' => 'nullable|array',
            'damaged_items.*' => 'exists:checklists,checklist_id',
        ]);
        
        // Calculate total nights and amount
        $nights = $booking->start_date->diffInDays($booking->end_date);
        $pricePerNight = $booking->rentalUnit->price_per_night;
        $rentalAmount = $nights * $pricePerNight;
        
        // Calculate damage fees if any
        $damageAmount = 0;
        $damagedItems = [];
        
        if (!empty($validated['damaged_items'])) {
            $damagedItems = \App\Models\Checklist::whereIn('checklist_id', $validated['damaged_items'])->get();
            foreach ($damagedItems as $item) {
                $damageAmount += $item->price;
            }
        }
        
        // Total amount is rental cost plus damage fees
        $totalAmount = $rentalAmount + $damageAmount;
        
        // Create a new checkout transaction
        $transaction = new CheckoutTransaction();
        $transaction->booking_id = $booking->booking_id;
        $transaction->user_id = Auth::id();
        $transaction->transaction_code = 'TRX-' . Str::upper(Str::random(8));
        $transaction->total_amount = $totalAmount;
        $transaction->payment_status = 'pending';
        $transaction->payment_method = $validated['payment_method'];
        $transaction->checkout_date = Carbon::now();
        $transaction->notes = $validated['notes'];
        $transaction->save();
        
        // Create a transaction detail for the rental
        $detail = new CheckoutTransactionDetail();
        $detail->transaction_id = $transaction->transaction_id;
        $detail->unit_id = $booking->unit_id;
        $detail->nights = $nights;
        $detail->price_per_night = $pricePerNight;
        $detail->subtotal = $rentalAmount;
        $detail->total = $rentalAmount;
        $detail->description = 'Booking from ' . $booking->start_date->format('d M Y') . ' to ' . $booking->end_date->format('d M Y');
        $detail->save();
        
        // Create transaction details for each damaged item
        foreach ($damagedItems as $item) {
            $damageDetail = new CheckoutTransactionDetail();
            $damageDetail->transaction_id = $transaction->transaction_id;
            $damageDetail->unit_id = $booking->unit_id;
            $damageDetail->checklist_id = $item->checklist_id;
            $damageDetail->subtotal = $item->price;
            $damageDetail->total = $item->price;
            $damageDetail->description = 'Damage fee: ' . $item->item . ' - ' . $item->description;
            $damageDetail->save();
        }
        
        // Update booking status to completed if payment method is cash or if payment is considered immediate
        if ($validated['payment_method'] === 'cash') {
            $booking->status = 'completed';
            $booking->save();
            
            $transaction->payment_status = 'paid';
            $transaction->save();
            
            return redirect()->route('bookings.checkout.success', $transaction->transaction_id)
                ->with('success', 'Checkout completed successfully!');
        }
        
        // For non-cash payments, redirect to the payments page
        return redirect()->route('payments.form', $transaction->transaction_id)
            ->with('success', 'Checkout completed. Please complete your payment.');
    }
    
    /**
     * Display the checkout success page.
     */
    public function checkoutSuccess($transactionId)
    {
        $transaction = CheckoutTransaction::with(['booking', 'booking.rentalUnit', 'transactionDetails'])
            ->findOrFail($transactionId);
        
        // Check if the authenticated user owns this transaction
        if (Auth::id() !== $transaction->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('bookings.checkout-success', compact('transaction'));
    }
}