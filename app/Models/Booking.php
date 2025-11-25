<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import this
use App\Models\ChannelPartner; // Make sure this is imported if not already

class Booking extends Model
{
    // If your primary key 'id' is still the auto-incrementing bigint,
    // you typically don't need to explicitly define protected $primaryKey,
    // public $incrementing, or protected $keyType. Laravel handles it by default.
    // If you HAD defined them for the 'booking_id' column in the past, remove them
    // as 'id' is your actual primary key.

    protected static function booted()
    {
        static::creating(function ($booking) {
            // Ensure this logic correctly generates the next sequential booking_id
            // based on the primary key 'id'. This seems correct.
            $lastId = Booking::max('id') ?? 0; // Gets the max value of the primary key 'id'
            $booking->booking_id = 'TNR' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);
        });
    }

    protected $fillable = [
        'booking_id',
        'customer_id',
        'project_id',
        // 'referred_by' will now store the ChannelPartner's ID
        'referred_by',
        'unit_name',
        'unit_size',
        'unit_unit',
        'booking_date',
        'followup_date',
        'invoice_amount',
        'other_amount',
        'total_amount',
        'status',
        'employee_id',
    ];

    // Relationships
    public function customer(): BelongsTo // Added type hint for clarity
    {
        return $this->belongsTo(Customer::class);
    }
     public function employee()
{
    return $this->belongsTo(Employee::class, 'employee_id');
}

    public function project(): BelongsTo // Added type hint for clarity
    {
        return $this->belongsTo(Project::class);
    }

    public function collection()
    {
        return $this->hasMany(Collection::class, 'booking_id');
    }

    /**
     * Get the channel partner that referred the booking.
     * The foreign key is 'referred_by' on the bookings table.
     * It relates to the 'id' column on the 'partners' table (used by ChannelPartner model).
     */
    public function channelPartner(): BelongsTo // Added type hint for clarity
    {
        // THIS IS THE KEY CHANGE: Explicitly define the local and owner keys
        return $this->belongsTo(ChannelPartner::class, 'referred_by', 'id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // If you had a 'partner_id' column that actually links to ChannelPartner,
    // and 'referred_by' is separate, let me know.
    // But based on our current discussion, 'referred_by' is what's being repurposed.
}
