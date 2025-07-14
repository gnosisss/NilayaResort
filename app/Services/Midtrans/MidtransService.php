<?php

namespace App\Services\Midtrans;

use App\Models\CheckoutTransaction;
use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MidtransService
{
    protected $serverKey;
    protected $clientKey;
    protected $isProduction;
    protected $isSanitized;
    protected $is3ds;
    
    public function __construct()
    {
        // Set Midtrans configuration
        $this->serverKey = config('midtrans.server_key');
        $this->clientKey = config('midtrans.client_key');
        $this->isProduction = config('midtrans.is_production');
        $this->isSanitized = config('midtrans.is_sanitized', true);
        $this->is3ds = config('midtrans.is_3ds', true);
        
        // Configure Midtrans global settings
        \Midtrans\Config::$serverKey = $this->serverKey;
        \Midtrans\Config::$isProduction = $this->isProduction;
        \Midtrans\Config::$isSanitized = $this->isSanitized;
        \Midtrans\Config::$is3ds = $this->is3ds;
    }
    
    /**
     * Generate Snap Token for a checkout transaction
     *
     * @param CheckoutTransaction $transaction
     * @return string
     */
    public function getSnapToken(CheckoutTransaction $transaction)
    {
        $orderId = $transaction->transaction_code;
        $amount = $transaction->remaining_balance;
        
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $amount,
            ],
            'customer_details' => [
                'first_name' => $transaction->user->name,
                'email' => $transaction->user->email,
            ],
            'item_details' => [
                [
                    'id' => 'BOOKING-' . $transaction->booking_id,
                    'price' => (int) $amount,
                    'quantity' => 1,
                    'name' => 'Payment for booking #' . $transaction->booking_id,
                ],
            ],
            // Set payment expiration time to 5 minutes
            'expiry' => [
                'unit' => 'minutes',
                'duration' => 5
            ],
        ];
        
        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            return $snapToken;
        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Handle Midtrans notification callback
     *
     * @param array $notificationData
     * @return PaymentTransaction|null
     */
    public function handleNotification(array $notificationData)
    {
        $transaction = null;
        
        try {
            $notification = new \Midtrans\Notification();
            
            $orderId = $notification->order_id;
            $statusCode = $notification->status_code;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status;
            $paymentType = $notification->payment_type;
            $grossAmount = $notification->gross_amount;
            
            // Get the checkout transaction
            $checkoutTransaction = CheckoutTransaction::where('transaction_code', $orderId)->first();
            
            if (!$checkoutTransaction) {
                Log::error('Midtrans Notification: Checkout transaction not found for order ID ' . $orderId);
                return null;
            }
            
            // Determine payment status based on transaction status
            $paymentStatus = 'pending';
            
            if ($transactionStatus == 'capture') {
                if ($paymentType == 'credit_card') {
                    if ($fraudStatus == 'challenge') {
                        $paymentStatus = 'pending';
                    } else {
                        $paymentStatus = 'completed';
                    }
                } else {
                    $paymentStatus = 'completed';
                }
            } else if ($transactionStatus == 'settlement') {
                $paymentStatus = 'completed';
            } else if ($transactionStatus == 'pending') {
                $paymentStatus = 'pending';
            } else if ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
                $paymentStatus = 'failed';
            }
            
            // Create or update payment transaction
            $transaction = PaymentTransaction::create([
                'transaction_id' => $checkoutTransaction->transaction_id,
                'user_id' => $checkoutTransaction->user_id,
                'payment_code' => 'MIDTRANS-' . strtoupper(Str::random(8)),
                'amount' => $grossAmount,
                'payment_method' => $paymentType,
                'payment_status' => $paymentStatus,
                'payment_notes' => 'Payment via Midtrans - ' . $paymentType,
                'payment_date' => now(),
                'payment_details' => json_encode($notificationData),
            ]);
            
            // Update checkout transaction status if fully paid
            if ($paymentStatus == 'completed') {
                if ($checkoutTransaction->is_fully_paid) {
                    $checkoutTransaction->update([
                        'payment_status' => 'paid',
                    ]);
                    
                    // Update booking status to confirmed/success
                    $booking = $checkoutTransaction->booking;
                    if ($booking) {
                        $booking->update([
                            'status' => 'confirmed'
                        ]);
                    }
                }
            }
            
            return $transaction;
        } catch (\Exception $e) {
            Log::error('Midtrans Notification Error: ' . $e->getMessage());
            return null;
        }
    }
}