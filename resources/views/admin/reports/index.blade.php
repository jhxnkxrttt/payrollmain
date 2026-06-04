@extends('layouts.app')

@section('title', 'Reports - Cafe Payroll')
@section('page-title', 'System Reports')

@section('content')
    <section class="report-grid">
        <article class="panel metric-card">
            <span class="metric-label">Employees</span>
            <strong class="metric-value">{{ $totalEmployees }}</strong>
        </article>
        <article class="panel metric-card">
            <span class="metric-label">Gross payroll</span>
            <strong class="metric-value">PHP {{ number_format($totalPayroll, 2) }}</strong>
        </article>
        <article class="panel metric-card">
            <span class="metric-label">Net pay</span>
            <strong class="metric-value">PHP {{ number_format($totalNetPay, 2) }}</strong>
        </article>
        <article class="panel metric-card">
            <span class="metric-label">Total deductions</span>
            <strong class="metric-value">PHP {{ number_format($totalDeductions, 2) }}</strong>
        </article>
        <article class="panel metric-card">
            <span class="metric-label">Payroll runs</span>
            <strong class="metric-value">{{ $payrollRuns }}</strong>
        </article>
        <article class="panel metric-card">
            <span class="metric-label">Payroll present days</span>
            <strong class="metric-value">{{ $payrollPresentDays }}</strong>
        </article>
        <article class="panel metric-card">
            <span class="metric-label">Payroll absent days</span>
            <strong class="metric-value">{{ $payrollAbsentDays }}</strong>
        </article>
        <article class="panel metric-card">
            <span class="metric-label">Payroll late count</span>
            <strong class="metric-value">{{ $payrollLateDays }}</strong>
        </article>
        <article class="panel metric-card">
            <span class="metric-label">Late deductions</span>
            <strong class="metric-value">PHP {{ number_format($payrollLateDeductions, 2) }}</strong>
        </article>
        <article class="panel metric-card">
            <span class="metric-label">Present</span>
            <strong class="metric-value">{{ $present }}</strong>
        </article>
        <article class="panel metric-card">
            <span class="metric-label">Late / Absent</span>
            <strong class="metric-value">{{ $late }} / {{ $absent }}</strong>
        </article>
    </section>
@endsection
