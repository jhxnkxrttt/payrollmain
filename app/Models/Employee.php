<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';

    protected $fillable = [
        'name',
        'position',
        'monthly_salary',
        'hire_date',
        'status'
    ];

    // RELATIONSHIP: Employee has many payrolls
    public function payrolls()
    {
        return $this->hasMany(Payroll::class, 'employee_id');
    }
}