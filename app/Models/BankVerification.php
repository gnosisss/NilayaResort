<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'document_status',
        'revision_notes',
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
        'document_status' => 'string',
    ];
    
    /**
     * The document status options.
     *
     * @var array<string, string>
     */
    public static $documentStatuses = [
        'pending' => 'Pending',
        'accepted' => 'Accepted',
        'revision' => 'Needs Revision',
        'rejected' => 'Rejected',
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
    
    /**
     * Get the document reviews for the bank verification.
     */
    public function documentReviews(): HasMany
    {
        return $this->hasMany(DocumentReview::class, 'verification_id', 'verification_id');
    }
    
    /**
     * Calculate credit score based on document reviews.
     */
    public function calculateCreditScore(): float
    {
        $reviews = $this->documentReviews;
        $totalReviews = $reviews->count();
        
        if ($totalReviews === 0) {
            return 0;
        }
        
        $acceptedCount = $reviews->where('status', 'accepted')->count();
        $revisionCount = $reviews->where('status', 'revision')->count();
        
        // Calculate score: accepted documents give full points
        // documents needing revision give half points
        // rejected documents give no points
        $score = (($acceptedCount * 1.0) + ($revisionCount * 0.5)) / $totalReviews * 100;
        
        return round($score, 2);
    }
    
    /**
     * Determine overall document status based on reviews.
     */
    public function determineDocumentStatus(): string
    {
        $reviews = $this->documentReviews;
        
        if ($reviews->count() === 0) {
            return 'pending';
        }
        
        if ($reviews->where('status', 'rejected')->count() > 0) {
            return 'rejected';
        }
        
        if ($reviews->where('status', 'revision')->count() > 0) {
            return 'revision';
        }
        
        if ($reviews->where('status', 'accepted')->count() === $reviews->count()) {
            return 'accepted';
        }
        
        return 'pending';
    }
}