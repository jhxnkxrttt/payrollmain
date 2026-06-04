<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // EMPLOYEES
        $totalEmployees = DB::table('employees')->count();

        // PAYROLL TOTALS
        $totalPayroll = DB::table('payroll')->sum('gross_pay');
        $totalNetPay = DB::table('payroll')->sum('net_pay');
        $totalDeductions = DB::table('payroll')->sum('total_deductions');
        $payrollRuns = DB::table('payroll')->count();
        $payrollPresentDays = DB::table('payroll')->sum('present_days');
        $payrollAbsentDays = DB::table('payroll')->sum('absent_days');
        $payrollLateDays = DB::table('payroll')->sum('late_days');
        $payrollLateDeductions = DB::table('payroll')->sum('late_deduction');

        // ATTENDANCE SUMMARY
        $present = DB::table('attendance')->where('status', 'present')->count();
        $late = DB::table('attendance')->where('status', 'late')->count();
        $absent = DB::table('attendance')->where('status', 'absent')->count();

        $salarySeries = DB::table('payroll')
            ->join('employees', 'payroll.employee_id', '=', 'employees.id')
            ->select('payroll.*', 'employees.name')
            ->orderBy('payroll.paid_date')
            ->orderBy('payroll.generated_at')
            ->get()
            ->groupBy('employee_id')
            ->map(fn ($items) => [
                'name' => $items->first()->name,
                'labels' => $items
                    ->map(fn ($pay) => $pay->paid_date ?? date('Y-m-d', strtotime($pay->generated_at)))
                    ->values(),
                'values' => $items
                    ->map(fn ($pay) => round((float) $pay->net_pay, 2))
                    ->values(),
            ])
            ->values();

        return view('admin.reports.index', compact(
            'totalEmployees',
            'totalPayroll',
            'totalNetPay',
            'totalDeductions',
            'payrollRuns',
            'payrollPresentDays',
            'payrollAbsentDays',
            'payrollLateDays',
            'payrollLateDeductions',
            'present',
            'late',
            'absent',
            'salarySeries'
        ));
    }
}
