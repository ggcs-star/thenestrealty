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
    'bank_name',
    'employee_name',
    'employee_number',
    'loan_amount',
    'loan_stage',
    'notes',
    'employee_id',
];
public function employee()
{
    return $this->belongsTo(Employee::class, 'employee_id');
}
}
