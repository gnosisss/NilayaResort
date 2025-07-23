<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentReview extends Model
{
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'review_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'verification_id',
        'document_id',
        'document_type',
        'status',
        'notes',
    ];

    /**
     * The document status options.
     *
     * @var array<string, string>
     */
    public static $documentStatuses = [
        'accepted' => 'Diterima',
        'revision' => 'Perlu Revisi',
        'rejected' => 'Ditolak',
    ];

    /**
     * Get the bank verification that the review belongs to.
     */
    public function bankVerification(): BelongsTo
    {
        return $this->belongsTo(BankVerification::class, 'verification_id', 'verification_id');
    }

    /**
     * Get the property document that the review belongs to.
     */
    public function propertyDocument(): BelongsTo
    {
        return $this->belongsTo(PropertyDocument::class, 'document_id', 'document_id');
    }
}