<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'booking_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'unit_id',
        'start_date',
        'end_date',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the user that made the booking.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the rental unit that was booked.
     */
    public function rentalUnit(): BelongsTo
    {
        return $this->belongsTo(RentalUnit::class, 'unit_id', 'unit_id');
    }

    

    /**
     * Get the checkout transaction for the booking.
     */
    public function checkoutTransaction(): HasOne
    {
        return $this->hasOne(CheckoutTransaction::class, 'booking_id', 'booking_id');
    }

    public function getFormattedStartDateAttribute()
    {
        return $this->start_date ? $this->start_date->format('d M Y') : 'N/A';
    }

    public function getFormattedEndDateAttribute()
    {
        return $this->end_date ? $this->end_date->format('d M Y') : 'N/A';
    }

    public function getCheckInDateAttribute()
    {
        return $this->start_date;
    }

    public function getCheckOutDateAttribute()
    {
        return $this->end_date;
    }
}