<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankVerification extends Model
{
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'verification_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'purchase_id',
        'bank_user_id',
        'documents_verified',
        'credit_approved',
        'credit_score',
        'approved_amount',
        'verification_notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'documents_verified' => 'boolean',
        'credit_approved' => 'boolean',
        'credit_score' => 'float',
        'approved_amount' => 'float',
    ];

    /**
     * Get the property purchase that the verification belongs to.
     */
    public function propertyPurchase(): BelongsTo
    {
        return $this->belongsTo(PropertyPurchase::class, 'purchase_id', 'purchase_id');
    }

    /**
     * Get the bank user that performed the verification.
     */
    public function bankUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'bank_user_id', 'id');
    }
    
    /**
     * Alias for bankUser to maintain backward compatibility.
     */
    public function bankOfficer(): BelongsTo
    {
        return $this->bankUser();
    }

    /**
     * Check if all documents are verified and credit is approved.
     */
    public function isFullyVerified(): bool
    {
        return $this->documents_verified && $this->credit_approved;
    }
}