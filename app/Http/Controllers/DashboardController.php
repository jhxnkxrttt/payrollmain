<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function employee()
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect('/');
        }

        $user = DB::table('users')
            ->where('id', $userId)
            ->first();

        if (!$user) {
            return redirect('/');
        }

        // CRITICAL FIX HERE
        $employee = DB::table('employees')
            ->where('id', $user->employee_id)
            ->first();

        // DEBUG (optional)
        // dd($user, $employee);

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
        $userId = session('user_id');

        if (!$userId) {
            return redirect('/');
        }

        $user = DB::table('users')
            ->where('id', $userId)
            ->first();

        $employee = DB::table('employees')
            ->where('id', $user->employee_id)
            ->first();

        return view('employee.profile', compact('user', 'employee'));
    }
    public function payslips()
    {
        $userId = session('user_id');

        $user = DB::table('users')->where('id', $userId)->first();

        $payslips = DB::table('payroll')
            ->where('employee_id', $user->employee_id)
            ->orderBy('generated_at', 'desc')
            ->get();

        return view('employee.payslips', compact('payslips'));
    }
    public function attendance()
    {
        $userId = session('user_id');

        $user = DB::table('users')->where('id', $userId)->first();

        $logs = DB::table('attendance')
            ->where('employee_id', $user->employee_id)
            ->orderBy('date', 'desc')
            ->get();

        return view('employee.attendance', compact('logs'));
    }
    public function timeIn()
    {
        $user = session('user_id');
        $emp = DB::table('users')->where('id', $user)->first();

        DB::table('attendance')->insert([
            'employee_id' => $emp->employee_id,
            'date' => date('Y-m-d'),
            'time_in' => now(),
            'status' => 'late'
        ]);

        return back();
    }

    public function timeOut()
    {
        $user = session('user_id');
        $emp = DB::table('users')->where('id', $user)->first();

        $attendance = DB::table('attendance')
            ->where('employee_id', $emp->employee_id)
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
            ->where('employee_id', $emp->employee_id)
            ->where('date', date('Y-m-d'))
            ->update([
                'time_out' => now(),
                'status' => $status
            ]);

        return back();
    }

}
