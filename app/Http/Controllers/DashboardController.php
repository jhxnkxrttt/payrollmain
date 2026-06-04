<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class DashboardController extends Controller
{
    private function currentUser()
    {
        $userId = session('user_id');

        if (!$userId) {
            return null;
        }

        return DB::table('users')->where('id', $userId)->first();
    }

    private function currentEmployee()
    {
        $user = $this->currentUser();

        if (!$user || !$user->employee_id) {
            return [null, $user];
        }

        $employee = DB::table('employees')
            ->where('id', $user->employee_id)
            ->first();

        return [$employee, $user];
    }

    public function employee()
    {
        [$employee, $user] = $this->currentEmployee();

        if (!$user) {
            return redirect('/');
        }

        return view('employee.dashboard', compact('employee'));
    }

    public function admin()
    {
        $totalEmployees = DB::table('employees')->count();

        $totalPayroll = DB::table('payroll')->sum('net_pay');

        $latestPayroll = DB::table('payroll')
            ->join('employees', 'payroll.employee_id', '=', 'employees.id')
            ->select('payroll.*', 'employees.name')
            ->orderBy('payroll.generated_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalEmployees',
            'totalPayroll',
            'latestPayroll'
        ));
    }

    public function profile()
    {
        [$employee, $user] = $this->currentEmployee();

        if (!$user) {
            return redirect('/');
        }

        return view('employee.profile', compact('user', 'employee'));
    }
    public function payslips()
    {
        [$employee, $user] = $this->currentEmployee();

        if (!$user) {
            return redirect('/');
        }

        $payslips = DB::table('payroll')
            ->when($employee, fn ($query) => $query->where('employee_id', $employee->id))
            ->when(!$employee, fn ($query) => $query->whereRaw('1 = 0'))
            ->orderBy('generated_at', 'desc')
            ->get();

        $salaryHistory = $payslips
            ->sortBy(fn ($pay) => $pay->paid_date ?? $pay->generated_at)
            ->values();

        $salaryChart = [
            'labels' => $salaryHistory
                ->map(fn ($pay) => $pay->paid_date ?? date('Y-m-d', strtotime($pay->generated_at)))
                ->values(),
            'values' => $salaryHistory
                ->map(fn ($pay) => round((float) $pay->net_pay, 2))
                ->values(),
        ];

        return view('employee.payslips', compact('payslips', 'salaryChart'));
    }
    public function attendance()
    {
        [$employee, $user] = $this->currentEmployee();

        if (!$user) {
            return redirect('/');
        }

        $logs = DB::table('attendance')
            ->when($employee, fn ($query) => $query->where('employee_id', $employee->id))
            ->when(!$employee, fn ($query) => $query->whereRaw('1 = 0'))
            ->orderBy('date', 'desc')
            ->get();

        $statusCounts = $logs->countBy('status');
        $attendanceChart = [
            'labels' => collect(['present', 'late', 'absent'])
                ->map(fn ($status) => ucfirst($status))
                ->values(),
            'values' => collect(['present', 'late', 'absent'])
                ->map(fn ($status) => (int) $statusCounts->get($status, 0))
                ->values(),
        ];

        return view('employee.attendance', compact('logs', 'attendanceChart'));
    }
    public function timeIn()
    {
        [$employee, $user] = $this->currentEmployee();

        if (!$user || !$employee) {
            return redirect('/');
        }

        DB::table('attendance')->insert([
            'employee_id' => $employee->id,
            'date' => date('Y-m-d'),
            'time_in' => now(),
            'status' => 'late'
        ]);

        return back();
    }

    public function timeOut()
    {
        [$employee, $user] = $this->currentEmployee();

        if (!$user || !$employee) {
            return redirect('/');
        }

        $attendance = DB::table('attendance')
            ->where('employee_id', $employee->id)
            ->where('date', date('Y-m-d'))
            ->first();

        $status = 'late';

        if ($attendance && $attendance->time_in) {
            $timeIn = Carbon::parse($attendance->time_in);
            $timeOut = Carbon::now();
            $workedHours = ($timeIn->diffInSeconds($timeOut) / 3600) - 1;
            $workedHours = max(0, $workedHours);
            $status = $workedHours >= 8 ? 'present' : 'late';
        }

        DB::table('attendance')
            ->where('employee_id', $employee->id)
            ->where('date', date('Y-m-d'))
            ->update([
                'time_out' => now(),
                'status' => $status
            ]);

        return back();
    }

}
