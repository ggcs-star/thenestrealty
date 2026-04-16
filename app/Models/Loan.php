<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_name',
        'booking_id',
        'unit_name',
        'bank_id',
        'employee_name',
        'employee_number',
        'loan_amount',
        'loan_stage_id',
        'notes',
        'employee_id',
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function stage()
    {
        return $this->belongsTo(\App\Models\LoanStage::class, 'loan_stage_id');
    }
    public function booking()
    {
        return $this->belongsTo(\App\Models\Booking::class, 'booking_id', 'id');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

}
