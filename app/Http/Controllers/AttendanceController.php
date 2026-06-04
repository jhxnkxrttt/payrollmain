<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    // SHOW PAGE
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

        return view('admin.attendance.index', compact('employees', 'attendance'));
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|integer',
            'date' => 'required|date',
            'time_in' => 'nullable|date_format:H:i',
            'time_out' => 'nullable|date_format:H:i',
        ]);

        $status = 'late';

        if ($request->time_in) {
            $timeIn = Carbon::parse($request->time_in);

            // assume 8:00 AM start shift
            $standardTime = Carbon::createFromTime(8, 0);

            $status = $timeIn->gt($standardTime) ? 'late' : 'present';
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

    // UPDATE (PUT / PATCH)
    public function update(Request $request, $id)
    {
        $attendance = DB::table('attendance')->where('id', $id)->first();

        if (!$attendance) {
            return back()->with('error', 'Attendance not found');
        }

        $status = 'late';

        if ($request->time_in) {
            $timeIn = Carbon::parse($request->time_in);
            $standardTime = Carbon::createFromTime(8, 0);

            $status = $timeIn->gt($standardTime) ? 'late' : 'present';
        }

        DB::table('attendance')
            ->where('id', $id)
            ->update([
                'employee_id' => $request->employee_id,
                'date' => $request->date,
                'time_in' => $request->time_in,
                'time_out' => $request->time_out,
                'status' => $status,
                'updated_at' => now()
            ]);

        return back()->with('success', 'Attendance updated!');
    }

    // DELETE
    public function destroy($id)
    {
        DB::table('attendance')->where('id', $id)->delete();

        return back()->with('success', 'Attendance deleted!');
    }
}