@extends('layouts.app')

@section('title', 'Employee Dashboard - Cafe Payroll')
@section('page-title', 'Employee Dashboard')

@section('content')
    <div class="stat-grid">
        <article class="panel stat-card">
            <span class="stat-label">Employee</span>
            <strong class="stat-value">{{ $employee->name ?? 'Welcome' }}</strong>
        </article>
        <article class="panel stat-card">
            <span class="stat-label">Position</span>
            <strong class="stat-value">{{ $employee->position ?? session('role') }}</strong>
        </article>
        <article class="panel stat-card">
            <span class="stat-label">Status</span>
            <strong class="stat-value">{{ ucfirst($employee->status ?? 'Active') }}</strong>
        </article>
        <article class="panel stat-card">
            <span class="stat-label">Monthly salary</span>
            <strong class="stat-value">PHP {{ number_format($employee->monthly_salary ?? 0, 2) }}</strong>
        </article>
    </div>

    <section class="panel">
        <div class="section-header">
            <div>
                <h2>Employee Menu</h2>
                <p>Access profile, payslips, and attendance records.</p>
            </div>
        </div>

        <div class="action-grid">
            <a class="panel action-card" href="{{ url('/employee/profile') }}">
                <strong>Profile</strong>
                <span>View your employment and account details.</span>
            </a>
            <a class="panel action-card" href="{{ url('/employee/payslips') }}">
                <strong>Payslips</strong>
                <span>Review generated payroll statements.</span>
            </a>
            <a class="panel action-card" href="{{ url('/employee/attendance') }}">
                <strong>Attendance</strong>
                <span>Check your attendance history.</span>
            </a>
        </div>
    </section>
@endsection
