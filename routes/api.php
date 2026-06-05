<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EmployeeApiController;
use App\Http\Controllers\Api\PayrollApiController;
use App\Http\Controllers\Api\AttendanceApiController;

Route::apiResource('employees', EmployeeApiController::class);
