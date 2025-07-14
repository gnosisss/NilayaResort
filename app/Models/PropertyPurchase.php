<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PropertyPurchase extends Model
{
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'purchase_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'unit_id',
        'purchase_code',
        'purchase_amount',
        'status',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'purchase_amount' => 'float',
    ];

    /**
     * Get the user that owns the property purchase.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the rental unit that is being purchased.
     */
    public function rentalUnit(): BelongsTo
    {
        return $this->belongsTo(RentalUnit::class, 'unit_id', 'unit_id');
    }

    /**
     * Get the documents for the property purchase.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(PropertyDocument::class, 'purchase_id', 'purchase_id');
    }

    /**
     * Get the bank verification for the property purchase.
     */
    public function bankVerification(): HasOne
    {
        return $this->hasOne(BankVerification::class, 'purchase_id', 'purchase_id');
    }

    /**
     * Generate a unique purchase code.
     */
    public static function generatePurchaseCode(): string
    {
        $prefix = 'PUR';
        $timestamp = now()->format('YmdHis');
        $random = rand(1000, 9999);
        
        return $prefix . $timestamp . $random;
    }
}