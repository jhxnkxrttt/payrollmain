<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    // DISPLAY EMPLOYEES
    public function index()
    {
        $employees = DB::table('employees')->get();

        return view('admin.employees.index', compact('employees'));
    }

    // SHOW CREATE FORM
    public function create()
    {
        return view('admin.employees.create');
    }

    // STORE EMPLOYEE
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'position' => 'required|string',
            'monthly_salary' => 'required|numeric',
            'hire_date' => 'required|date',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        // INSERT EMPLOYEE
        $employeeId = DB::table('employees')->insertGetId([
            'name' => $request->name,
            'position' => $request->position,
            'monthly_salary' => $request->monthly_salary,
            'hire_date' => $request->hire_date,
            'status' => 'active',
            'created_at' => now()
        ]);

        // CREATE USER ACCOUNT
        DB::table('users')->insert([
            'employee_id' => $employeeId,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->position,
            'created_at' => now()
        ]);

        return redirect('/admin/employees')
            ->with('success', 'Employee added successfully!');
    }

    // SHOW EDIT FORM
    public function edit($id)
    {
        $employee = DB::table('employees')->where('id', $id)->first();

        return view('admin.employees.edit', compact('employee'));
    }

    // UPDATE EMPLOYEE
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'position' => 'required|string',
            'monthly_salary' => 'required|numeric'
        ]);

        DB::table('employees')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'position' => $request->position,
                'monthly_salary' => $request->monthly_salary,
                'updated_at' => now()
            ]);

        return redirect('/admin/employees')
            ->with('success', 'Employee updated successfully!');
    }

    // DELETE EMPLOYEE (FIXED NAME)
    public function destroy($id)
    {
        DB::table('employees')->where('id', $id)->delete();

        // optional: delete user account too
        DB::table('users')->where('employee_id', $id)->delete();

        return redirect('/admin/employees')
            ->with('success', 'Employee deleted successfully!');
    }
}