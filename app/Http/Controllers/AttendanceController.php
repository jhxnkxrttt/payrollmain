<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    // SHOW ATTENDANCE PAGE
    public function index()
    {
        $employees = DB::table('employees')->get();

        $attendance = DB::table('attendance')

            ->join('employees', 'attendance.employee_id', '=', 'employees.id')

            ->select(
                'attendance.*',
                'employees.name',
                'employees.position'
            )

            ->orderBy('date', 'desc')

            ->get();

        return view('admin.attendance.index', compact(
            'employees',
            'attendance'
        ));
    }

    // SAVE ATTENDANCE
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => ['required', 'integer'],
            'date' => ['required', 'date'],
            'time_in' => ['nullable', 'date_format:H:i'],
            'time_out' => ['nullable', 'date_format:H:i'],
        ]);

        $status = 'late';

        if ($request->time_in && $request->time_out) {
            $timeIn = Carbon::parse($request->time_in);
            $timeOut = Carbon::parse($request->time_out);
            $workedHours = ($timeIn->diffInSeconds($timeOut) / 3600) - 1;
            $workedHours = max(0, $workedHours);

            $status = $workedHours >= 8 ? 'present' : 'late';
        }

        DB::table('attendance')->insert([
            'employee_id' => $request->employee_id,
            'date' => $request->date,
            'time_in' => $request->time_in,
            'time_out' => $request->time_out,
            'status' => $status,
            'created_at' => now()
        ]);

        return back()->with('success', 'Attendance added!');
    }
}