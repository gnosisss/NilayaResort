<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnitFacility extends Model
{
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'unit_facility_id';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'unit_facilities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'unit_id',
        'facility_id',
    ];

    /**
     * Get the rental unit that this facility belongs to.
     */
    public function rentalUnit(): BelongsTo
    {
        return $this->belongsTo(RentalUnit::class, 'unit_id', 'unit_id');
    }

    /**
     * Get the facility that belongs to this rental unit.
     */
    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class, 'facility_id', 'facility_id');
    }
}