<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentTransaction extends Model
{
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'payment_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'transaction_id',
        'user_id',
        'payment_code',
        'amount',
        'payment_method',
        'payment_status',
        'payment_proof',
        'payment_notes',
        'payment_date',
        'payment_details',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'float',
        'payment_date' => 'datetime',
    ];

    /**
     * Get the checkout transaction associated with the payment.
     */
    public function checkoutTransaction(): BelongsTo
    {
        return $this->belongsTo(CheckoutTransaction::class, 'transaction_id', 'transaction_id');
    }

    /**
     * Get the user that made the payment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}