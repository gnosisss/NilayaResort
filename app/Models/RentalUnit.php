<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RentalUnit extends Model
{
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'unit_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'address',
        'type',
        'slug',
        'price_per_night',
    ];

    /**
     * Get the user that owns the rental unit.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the category that the rental unit belongs to.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    /**
     * Get the facilities for the rental unit.
     */
    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(Facility::class, 'unit_facilities', 'unit_id', 'facility_id')
            ->withTimestamps();
    }

    /**
     * Get the images for the rental unit.
     */
    public function images(): HasMany
    {
        return $this->hasMany(Image::class, 'unit_id', 'unit_id');
    }

    /**
     * Get the availabilities for the rental unit.
     */
    public function availabilities(): HasMany
    {
        return $this->hasMany(Availability::class, 'unit_id', 'unit_id');
    }

    /**
     * Get the bookings for the rental unit.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'unit_id', 'unit_id');
    }

    /**
     * Get the checkout transaction details for the rental unit.
     */
    public function checkoutTransactionDetails(): HasMany
    {
        return $this->hasMany(CheckoutTransactionDetail::class, 'unit_id', 'unit_id');
    }
}