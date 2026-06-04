<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('login');
});

// AUTH
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// DASHBOARDS
Route::get('/admin/dashboard', [DashboardController::class, 'admin']);
Route::get('/employee/dashboard', [DashboardController::class, 'employee']);
Route::get('/employee/profile', [DashboardController::class, 'profile']);
Route::get('/employee/payslips', [DashboardController::class, 'payslips']);
Route::get('/employee/attendance', [DashboardController::class, 'attendance']);
Route::post('/employee/time-in', [DashboardController::class, 'timeIn']);
Route::post('/employee/time-out', [DashboardController::class, 'timeOut']);

use App\Http\Controllers\EmployeeController;

Route::get('/admin/employees', [EmployeeController::class, 'index']);
Route::get('/admin/employees/create', [EmployeeController::class, 'create']);
Route::post('/admin/employees/store', [EmployeeController::class, 'store']);

Route::get('/admin/employees/edit/{id}', [EmployeeController::class, 'edit']);
Route::post('/admin/employees/update/{id}', [EmployeeController::class, 'update']);

Route::get('/admin/employees/delete/{id}', [EmployeeController::class, 'delete']);

use App\Http\Controllers\PayrollController;

Route::get('/admin/payroll', [PayrollController::class, 'index']);

Route::post('/admin/payroll/generate/{id}', [PayrollController::class, 'generate']);
Route::get('/admin/payroll/history', [PayrollController::class, 'history']);

use App\Http\Controllers\AttendanceController;

Route::get('/admin/attendance', [AttendanceController::class, 'index']);

Route::post('/admin/attendance/store', [AttendanceController::class, 'store']);

use App\Http\Controllers\DeductionController;

Route::get('/admin/deductions', [DeductionController::class, 'index']);

Route::post('/admin/deductions/store', [DeductionController::class, 'store']);

use App\Http\Controllers\ReportController;

Route::get('/admin/reports', [ReportController::class, 'index']);

use App\Http\Controllers\PayslipController;

Route::get('/payslip/{id}/download', [PayslipController::class, 'download'])
    ->name('payslip.download');