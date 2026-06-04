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

        $pdf = PDF::loadView('pdf.payslip', [
            'payslip' => $payslip,
            'employee' => $employee,
            'selectedDeductions' => $selectedDeductions,
        ]);

        return $pdf->download('payslip-'.$employee->name.'.pdf');
    }
}