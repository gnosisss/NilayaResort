<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Availability extends Model
{
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'availability_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'unit_id',
        'start_date',
        'end_date',
        'is_available',
        'status',
        'price',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_available' => 'boolean',
    ];

    /**
     * Get the rental unit that this availability belongs to.
     */
    public function rentalUnit(): BelongsTo
    {
        return $this->belongsTo(RentalUnit::class, 'unit_id', 'unit_id');
    }
}