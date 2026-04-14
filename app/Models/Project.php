<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'ex_unit',           // Added missing field
        'units',             // Added units array field
        'unit_sizes',
        'booked_units',      // Added booked units array field
        'address',
        'builder_name',
        'builder_number',
        'assigned_employee',
        'documents',
        'status',            // Added status field
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'documents' => 'array',  // Automatically handle JSON encoding/decoding
        'units' => 'array',      // Cast units to array
        'unit_sizes' => 'array',
        'booked_units' => 'array', // Cast booked_units to array
        'ex_unit' => 'integer',  // Ensure ex_unit is always an integer
    ];

    /**
     * Get the assigned employee details
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'assigned_employee');
    }

    /**
     * Get the documents as an array
     * This accessor ensures documents is always an array, even if null
     */
    public function getDocumentsAttribute($value)
    {
        if (is_string($value)) {
            return json_decode($value, true) ?: [];
        }
        return $value ?: [];
    }

    /**
     * Get the units as an array
     * This accessor ensures units is always an array, even if null
     */
    public function getUnitsAttribute($value)
    {
        if (is_string($value)) {
            return json_decode($value, true) ?: [];
        }
        return $value ?: [];
    }
    public function getUnitSizesAttribute($value)
    {
        if (is_string($value)) {
            return json_decode($value, true) ?: [];
        }
        return $value ?: [];
    }
    /**
     * Get the booked units as an array
     * This accessor ensures booked_units is always an array, even if null
     */
    public function getBookedUnitsAttribute($value)
    {
        if (is_string($value)) {
            return json_decode($value, true) ?: [];
        }
        return $value ?: [];
    }

    /**
     * Get available units (units that are not booked)
     */
    public function getAvailableUnitsAttribute()
    {
        return array_diff($this->units, $this->booked_units);
    }

    /**
     * Check if a unit is available
     */
    public function isUnitAvailable($unit)
    {
        return in_array($unit, $this->available_units);
    }

    /**
     * Book a unit
     */
    public function bookUnit($unit)
    {
        if ($this->isUnitAvailable($unit)) {
            $bookedUnits = $this->booked_units;
            $bookedUnits[] = $unit;
            $this->booked_units = $bookedUnits;
            $this->save();
            return true;
        }
        return false;
    }

    /**
     * Unbook a unit
     */
    public function unbookUnit($unit)
    {
        $bookedUnits = $this->booked_units;
        $key = array_search($unit, $bookedUnits);
        if ($key !== false) {
            unset($bookedUnits[$key]);
            $this->booked_units = array_values($bookedUnits);
            $this->save();
            return true;
        }
        return false;
    }

    /**
     * Get formatted units display
     */
    public function getFormattedUnitsAttribute()
    {
        if (empty($this->units)) {
            return 'No units extracted';
        }

        return implode(', ', $this->units);
    }

    /**
     * Scope to filter projects by assigned employee
     */
    public function scopeAssignedTo($query, $employeeId)
    {
        return $query->where('assigned_employee', $employeeId);
    }

    /**
     * Get formatted builder contact info
     */
    public function getBuilderContactAttribute()
    {
        return $this->builder_name . ' (' . $this->builder_number . ')';
    }
}