<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PaymentCommitment extends Model
{
    use HasFactory;
        protected $fillable = [
        'customer_id',
        'booking_id',
        'loan_payments',
        'ac_transfer_payments',
        'other_mode_payments',
    ];

    protected $casts = [
        'loan_payments' => 'array',
        'ac_transfer_payments' => 'array',
        'other_mode_payments' => 'array',
    ];

    // Relationships (optional)
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
