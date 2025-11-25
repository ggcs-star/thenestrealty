<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;
    public function partner() {
        return $this->belongsTo(ChannelPartner::class, 'partner_id');
    }

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function booking() {
        return $this->belongsTo(Booking::class);
    }

protected $fillable = [
    'partner_id',
    'project_id',
    'customer_id',
    'booking_id',
    'unit_name',
    'total_amount',
    'partner_commission_rate', // <-- Add this
    'amount',
];

public function getPointsAttribute()
{
    return amountToPoints($this->total_amount);
}


}
