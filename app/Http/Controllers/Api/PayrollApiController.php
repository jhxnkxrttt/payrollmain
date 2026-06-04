<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use Illuminate\Http\Request;

class PayrollApiController extends Controller
{
    // GET ALL PAYROLLS
    public function index()
    {
        return response()->json([
            'success' => true,
            'payroll' => Payroll::with('employee')->latest()->get()
        ]);
    }

    // CREATE PAYROLL
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'paid_date' => 'required|date',
            'cut_off_start' => 'required|date',
            'cut_off_end' => 'required|date',
            'gross_pay' => 'required|numeric',
            'total_deductions' => 'required|numeric',
        ]);

        $netPay = $request->gross_pay - $request->total_deductions;

        $payroll = Payroll::create([
            'employee_id' => $request->employee_id,
            'paid_date' => $request->paid_date,
            'cut_off_start' => $request->cut_off_start,
            'cut_off_end' => $request->cut_off_end,
            'present_days' => $request->present_days ?? 0,
            'absent_days' => $request->absent_days ?? 0,
            'late_days' => $request->late_days ?? 0,
            'total_days' => $request->total_days ?? 0,
            'gross_pay' => $request->gross_pay,
            'late_deduction' => $request->late_deduction ?? 0,
            'selected_deductions' => $request->selected_deductions ?? '',
            'total_deductions' => $request->total_deductions,
            'net_pay' => $netPay,
            'generated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payroll created successfully',
            'data' => $payroll
        ], 201);
    }
}