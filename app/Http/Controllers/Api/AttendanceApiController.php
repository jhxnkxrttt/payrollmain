<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceApiController extends Controller
{
    // GET ALL ATTENDANCES
    public function index()
    {
        return response()->json([
            'success' => true,
            'attendances' => Attendance::with('employee')->latest()->get()
        ]);
    }

    // GET SINGLE ATTENDANCE
    public function show($id)
{
    return response()->json([
        'success' => true,
        'data' => Attendance::with('employee')->findOrFail($id)
    ]);
}

public function update(Request $request, $id)
{
    $attendance = Attendance::findOrFail($id);

    $attendance->update($request->only([
        'employee_id',
        'date',
        'time_in',
        'time_out',
        'status'
    ]));

    return response()->json([
        'success' => true,
        'message' => 'Attendance updated',
        'data' => $attendance
    ]);
}

public function destroy($id)
{
    Attendance::findOrFail($id)->delete();

    return response()->json([
        'success' => true,
        'message' => 'Attendance deleted'
    ]);
}
}