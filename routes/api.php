<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EmployeeApiController;
use App\Http\Controllers\Api\PayrollApiController;

Route::get('/employees', [EmployeeApiController::class, 'index']);
Route::get('/payroll', [PayrollApiController::class, 'index']);
Route::post('/payroll', [PayrollApiController::class, 'store']);