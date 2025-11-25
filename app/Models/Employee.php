<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'employee_code',
        'name',
        'phone_number',
        'email',
        'birthdate',
        'designation',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
    ];
    public function customers()
{
    return $this->hasMany(ChannelPartner::class, 'employee_id');
}
public function loans()
{
    return $this->hasMany(Loan::class, 'employee_id');
}
}
