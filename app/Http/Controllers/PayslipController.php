<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use PDF;

class PayslipController extends Controller
{
    public function download($id)
    {
        $payslip = DB::table('payroll')
            ->where('id', $id)
            ->first();

        if (!$payslip) {
            return back()->withErrors(['error' => 'Payslip not found.']);
        }

        $employee = DB::table('employees')
            ->where('id', $payslip->employee_id)
            ->first();

        $selectedDeductions = json_decode($payslip->selected_deductions ?? '[]', true);

        $salaryHistory = DB::table('payroll')
            ->where('employee_id', $payslip->employee_id)
            ->orderBy('paid_date')
            ->orderBy('generated_at')
            ->get();

        $salaryChart = [
            'labels' => $salaryHistory
                ->map(fn ($pay) => $pay->paid_date ?? date('Y-m-d', strtotime($pay->generated_at)))
                ->values(),
            'values' => $salaryHistory
                ->map(fn ($pay) => round((float) $pay->net_pay, 2))
                ->values(),
        ];

        $pdf = PDF::loadView('pdf.payslip', [
            'payslip' => $payslip,
            'employee' => $employee,
            'selectedDeductions' => $selectedDeductions,
            'salaryChart' => $salaryChart,
        ]);

        return $pdf->download('payslip-'.$employee->name.'.pdf');
    }
}
