<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;

class EmployeeApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'employees' => Employee::all()
        ]);
    }
}