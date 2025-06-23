<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Facility extends Model
{
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'facility_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'facility_name',
    ];

    /**
     * Get the rental units that have this facility.
     */
    public function rentalUnits(): BelongsToMany
    {
        return $this->belongsToMany(RentalUnit::class, 'unit_facilities', 'facility_id', 'unit_id')
            ->withTimestamps();
    }
}