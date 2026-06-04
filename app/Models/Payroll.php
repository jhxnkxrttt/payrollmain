<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $table = 'payroll';

    protected $fillable = [
        'employee_id',
        'paid_date',
        'cut_off_start',
        'cut_off_end',
        'present_days',
        'absent_days',
        'late_days',
        'total_days',
        'gross_pay',
        'late_deduction',
        'selected_deductions',
        'total_deductions',
        'net_pay',
        'generated_at'
    ];

    // RELATIONSHIP: Payroll belongs to Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
