<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'customer_id',
        'partner_id',
        'project_id',
        'date',
        'amount',
        'mode',
        'status',
        'employee_id',
    ];

    protected $appends = ['customer_name'];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
        'status' => 'string', // enum mapped to string
    ];

    /**
     * Collection belongs to Customer
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
public function employee()
{
    return $this->belongsTo(Employee::class, 'employee_id');
}
    /**
     * Accessor for customer_name attribute
     */
    public function getCustomerNameAttribute(): ?string
    {
        return $this->customer?->name;
    }

    /**
     * Collection belongs to Booking
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Collection belongs to Partner (assuming ChannelPartner model exists)
     */
    public function partner(): BelongsTo
    {
        return $this->belongsTo(ChannelPartner::class);
    }

    /**
     * Collection belongs to Project
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
