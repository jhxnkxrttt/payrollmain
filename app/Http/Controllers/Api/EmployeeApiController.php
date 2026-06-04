<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'employees' => Employee::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'position' => 'required',
            'monthly_salary' => 'required|numeric',
            'hire_date' => 'required|date',
            'status' => 'required'
        ]);

        $employee = Employee::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Employee created',
            'data' => $employee
        ], 201);
    }

    public function show($id)
    {
        return response()->json([
            'success' => true,
            'data' => Employee::findOrFail($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Employee updated',
            'data' => $employee
        ]);
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return response()->json([
            'success' => true,
            'message' => 'Employee deleted'
        ]);
    }
}