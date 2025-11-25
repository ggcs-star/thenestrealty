<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_number',
        'email',
        'dob',
        'aadhar_number',
        'pan_number',
        'referred_by',
        'builder_name',
        'partner_name',
        'employee_id',
    ];

    /**
     * Get all collections for the customer.
     */
  

     public function collections(): HasMany
    {
        return $this->hasMany(Collection::class, 'customer_id'); // 🔧 fix: foreign key should be customer_id
    }
 public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Optionally, if customer is linked with bookings:
     */
    // public function bookings(): HasMany
    // {
    //     return $this->hasMany(Booking::class, 'customer_id');
    // }
}
