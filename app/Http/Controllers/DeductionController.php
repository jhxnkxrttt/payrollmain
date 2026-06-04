<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeductionController extends Controller
{
    // SHOW PAGE
    public function index()
    {
        $employees = DB::table('employees')->get();

        $deductions = DB::table('deductions')
            ->join('employees', 'deductions.employee_id', '=', 'employees.id')
            ->select('deductions.*', 'employees.name')
            ->orderBy('deductions.created_at', 'desc')
            ->get();

        return view('admin.deductions.index', compact('employees', 'deductions'));
    }

    // SAVE DEDUCTION
    public function store(Request $request)
{
    $employee = DB::table('employees')
        ->where('id', $request->employee_id)
        ->first();

    $amount = $request->amount;

    // AUTO COMPUTATION
    if ($request->type == 'SSS') {
        $amount = $employee->monthly_salary * 0.045;
    }

    if ($request->type == 'PhilHealth') {
        $amount = $employee->monthly_salary * 0.025;
    }

    if ($request->type == 'Pag-IBIG') {
        $amount = 200;
    }

    if ($request->type == 'Other') {
        $amount = $request->amount;
    }

    DB::table('deductions')->insert([
        'employee_id' => $request->employee_id,
        'type' => $request->type,
        'amount' => $amount,
        'description' => $request->description,
        'created_at' => now()
    ]);

    return back()->with('success', 'Deduction saved successfully!');
}
}