<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    // GET ALL EMPLOYEES (FOR FORM)
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

    // POST (GENERATE PAYROLL)
    public function store(Request $request, $id)
    {
        return $this->generate($request, $id);
    }

    // CORE GENERATE LOGIC
    public function generate(Request $request, $id)
    {
        $request->validate([
            'paid_date' => 'required|date',
            'present_days' => 'required|integer|min:0|max:15',
            'absent_days' => 'required|integer|min:0|max:15',
            'late_days' => 'required|integer|min:0|max:15',
            'deduction_ids' => 'nullable|array',
            'deduction_ids.*' => 'integer',
        ]);

        $employee = DB::table('employees')->where('id', $id)->first();

        if (!$employee) {
            return back()->withErrors(['employee' => 'Employee not found.']);
        }

        // VALIDATIONS
        if (($request->present_days + $request->absent_days) > 15) {
            return back()->withErrors([
                'attendance' => 'Total days cannot exceed 15.'
            ]);
        }

        if ($request->late_days > $request->present_days) {
            return back()->withErrors([
                'attendance' => 'Late days cannot exceed present days.'
            ]);
        }

        // DEDUCTIONS
        $selected = DB::table('deductions')
            ->where('employee_id', $id)
            ->whereIn('id', $request->deduction_ids ?? [])
            ->get();

        // COMPUTATION
        $dailyRate = $employee->monthly_salary / 15;
        $grossPay = $dailyRate * $request->present_days;
        $lateDeduction = $request->late_days * ($dailyRate * 0.20);
        $manualDeduction = $selected->sum('amount');
        $totalDeduction = $lateDeduction + $manualDeduction;
        $netPay = max($grossPay - $totalDeduction, 0);

        // INSERT PAYROLL
        $idPayroll = DB::table('payroll')->insertGetId([
            'employee_id' => $id,
            'paid_date' => $request->paid_date,
            'cut_off_start' => null,
            'cut_off_end' => null,
            'present_days' => $request->present_days,
            'absent_days' => $request->absent_days,
            'late_days' => $request->late_days,
            'total_days' => $request->present_days,
            'gross_pay' => $grossPay,
            'late_deduction' => $lateDeduction,
            'selected_deductions' => $selected->map(fn($d) => [
                'type' => $d->type,
                'amount' => (float) $d->amount,
                'description' => $d->description,
            ])->toJson(),
            'total_deductions' => $totalDeduction,
            'net_pay' => $netPay,
            'generated_at' => now(),
        ]);

        return redirect('/admin/payroll/history')
            ->with('success', 'Payroll generated successfully.');
    }

    // GET HISTORY
    public function history()
    {
        $payrolls = DB::table('payroll')
            ->join('employees', 'payroll.employee_id', '=', 'employees.id')
            ->select('payroll.*', 'employees.name', 'employees.position')
            ->orderBy('payroll.generated_at', 'desc')
            ->get();

        $salarySeries = $payrolls
            ->sortBy(fn ($pay) => $pay->paid_date ?? $pay->generated_at)
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

        return view('admin.payroll.history', compact('payrolls', 'salarySeries'));
    }

    // SHOW SINGLE PAYROLL (API STYLE READY)
    public function show($id)
    {
        return DB::table('payroll')
            ->join('employees', 'payroll.employee_id', '=', 'employees.id')
            ->select('payroll.*', 'employees.name', 'employees.position')
            ->where('payroll.id', $id)
            ->first();
    }

    // UPDATE PAYROLL (PUT/PATCH)
    public function update(Request $request, $id)
    {
        DB::table('payroll')->where('id', $id)->update([
            'paid_date' => $request->paid_date,
            'present_days' => $request->present_days,
            'absent_days' => $request->absent_days,
            'late_days' => $request->late_days,
            'updated_at' => now()
        ]);

        return back()->with('success', 'Payroll updated.');
    }

    // DELETE PAYROLL
    public function destroy($id)
    {
        DB::table('payroll')->where('id', $id)->delete();

        return back()->with('success', 'Payroll deleted.');
    }
}
