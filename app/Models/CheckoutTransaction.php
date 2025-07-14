<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CheckoutTransaction extends Model
{
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'transaction_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'booking_id',
        'user_id',
        'transaction_code',
        'total_amount',
        'payment_status',
        'payment_method',
        'checkout_date',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_amount' => 'float',
        'checkout_date' => 'datetime',
    ];

    /**
     * Get the user that made the checkout transaction.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the booking associated with the checkout transaction.
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'booking_id');
    }

    /**
     * Get the transaction details for the checkout transaction.
     */
    public function transactionDetails(): HasMany
    {
        return $this->hasMany(CheckoutTransactionDetail::class, 'transaction_id', 'transaction_id');
    }
    
    /**
     * Get the payment transactions for the checkout transaction.
     */
    public function paymentTransactions(): HasMany
    {
        return $this->hasMany(PaymentTransaction::class, 'transaction_id', 'transaction_id');
    }
    
    /**
     * Calculate the total amount paid for this checkout transaction.
     */
    public function getTotalPaidAttribute(): float
    {
        return $this->paymentTransactions()
            ->where('payment_status', 'completed')
            ->sum('amount');
    }
    
    /**
     * Calculate the remaining balance to be paid.
     */
    public function getRemainingBalanceAttribute(): float
    {
        return max(0, $this->total_amount - $this->total_paid);
    }
    
    /**
     * Check if the checkout transaction is fully paid.
     */
    public function getIsFullyPaidAttribute(): bool
    {
        return $this->remaining_balance <= 0;
    }
    
    /**
     * Check if the transaction is fully paid.
     * Method alias for getIsFullyPaidAttribute for more readable code.
     *
     * @return bool
     */
    public function isFullyPaid()
    {
        return $this->is_fully_paid;
    }
}