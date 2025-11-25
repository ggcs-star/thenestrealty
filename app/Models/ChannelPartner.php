<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChannelPartner extends Model
{
    protected $table = 'partners';

    protected $fillable = [
        'partner_name',
        'number_contact',
        'mail_id',
        'date_of_birth',
        'aadhaar_card',
        'pan_card',
        'commission',
        'status',
        'employee_id',
    ];

    public function employee()
{
    return $this->belongsTo(Employee::class, 'employee_id');
}

}