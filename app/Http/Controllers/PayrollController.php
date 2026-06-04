<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    public function index()
    {
        $employees = DB::table('employees')
            ->orderBy('name')
            ->get();

        $deductions = DB::table('deductions')
            ->orderBy('type')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('employee_id');

        return view('admin.payroll.index', compact('employees', 'deductions'));
    }

    public function generate(Request $request, $id)
    {
        $request->validate([
            'paid_date' => ['required', 'date'],
            'present_days' => ['required', 'integer', 'min:0', 'max:15'],
            'absent_days' => ['required', 'integer', 'min:0', 'max:15'],
            'late_days' => ['required', 'integer', 'min:0', 'max:15'],
            'deduction_ids' => ['nullable', 'array'],
            'deduction_ids.*' => ['integer'],
        ]);

        $employee = DB::table('employees')
            ->where('id', $id)
            ->first();

        if (!$employee) {
            return back()->withErrors(['employee' => 'Employee not found.']);
        }

        $presentDays = (int) $request->present_days;
        $absentDays = (int) $request->absent_days;
        $lateDays = (int) $request->late_days;

        if (($presentDays + $absentDays) > 15) {
            return back()->withErrors([
                'attendance' => 'Present days and absent days cannot be more than 15 days total.',
            ])->withInput();
        }

        if ($lateDays > $presentDays) {
            return back()->withErrors([
                'attendance' => 'Late count cannot be greater than present days.',
            ])->withInput();
        }

        $selectedDeductionIds = $request->input('deduction_ids', []);
        $selectedDeductions = collect();

        if (!empty($selectedDeductionIds)) {
            $selectedDeductions = DB::table('deductions')
                ->where('employee_id', $id)
                ->whereIn('id', $selectedDeductionIds)
                ->get();
        }

        $dailyRate = $employee->monthly_salary / 15;
        $grossPay = $dailyRate * $presentDays;
        $lateDeduction = $lateDays * ($dailyRate * 0.20);
        $manualDeduction = $selectedDeductions->sum('amount');
        $totalDeduction = $lateDeduction + $manualDeduction;
        $netPay = max($grossPay - $totalDeduction, 0);

        DB::table('payroll')->insert([
            'employee_id' => $id,
            'paid_date' => $request->paid_date,
            'cut_off_start' => null,
            'cut_off_end' => null,
            'present_days' => $presentDays,
            'absent_days' => $absentDays,
            'late_days' => $lateDays,
            'total_days' => $presentDays,
            'gross_pay' => $grossPay,
            'late_deduction' => $lateDeduction,
            'selected_deductions' => $selectedDeductions
                ->map(fn ($deduction) => [
                    'type' => $deduction->type,
                    'amount' => (float) $deduction->amount,
                    'description' => $deduction->description,
                ])
                ->values()
                ->toJson(),
            'total_deductions' => $totalDeduction,
            'net_pay' => $netPay,
            'generated_at' => now(),
        ]);

        return redirect('/admin/payroll/history')
            ->with('success', 'Payroll generated successfully.');
    }

    public function history()
    {
        $payrolls = DB::table('payroll')
            ->join('employees', 'payroll.employee_id', '=', 'employees.id')
            ->select('payroll.*', 'employees.name', 'employees.position')
            ->orderBy('payroll.generated_at', 'desc')
            ->get();

        return view('admin.payroll.history', compact('payrolls'));
    }
}
