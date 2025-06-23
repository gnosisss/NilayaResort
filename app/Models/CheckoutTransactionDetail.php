<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CheckoutTransactionDetail extends Model
{
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'detail_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'transaction_id',
        'unit_id',
        'checklist_id',
        'nights',
        'price_per_night',
        'subtotal',
        'total',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'nights' => 'integer',
        'price_per_night' => 'float',
        'subtotal' => 'float',
        'discount' => 'float',
        'tax' => 'float',
        'total' => 'float',
    ];

    /**
     * Get the transaction that owns the detail.
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(CheckoutTransaction::class, 'transaction_id', 'transaction_id');
    }

    /**
     * Get the rental unit associated with the detail.
     */
    public function rentalUnit(): BelongsTo
    {
        return $this->belongsTo(RentalUnit::class, 'unit_id', 'unit_id');
    }

    /**
     * Get the checklist associated with the detail.
     */
    public function checklist(): BelongsTo
    {
        return $this->belongsTo(Checklist::class, 'checklist_id', 'checklist_id');
    }
}