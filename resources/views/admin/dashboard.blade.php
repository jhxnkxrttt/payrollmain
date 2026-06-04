@extends('layouts.app')

@section('title', 'Admin Dashboard - Cafe Payroll')
@section('page-title', 'Admin Dashboard')

@section('content')
    <div class="stat-grid">
        <article class="panel stat-card">
            <span class="stat-label">Total employees</span>
            <strong class="stat-value">{{ $totalEmployees ?? 0 }}</strong>
        </article>
        <article class="panel stat-card">
            <span class="stat-label">Total net payroll</span>
            <strong class="stat-value">PHP {{ number_format($totalPayroll ?? 0, 2) }}</strong>
        </article>
        <article class="panel stat-card">
            <span class="stat-label">Payroll tools</span>
            <strong class="stat-value">6</strong>
        </article>
        <article class="panel stat-card">
            <span class="stat-label">Workspace</span>
            <strong class="stat-value">Live</strong>
        </article>
    </div>

    <section class="panel">
        <div class="section-header">
            <div>
                <h2>Admin Menu</h2>
                <p>Manage payroll operations from one place.</p>
            </div>
        </div>

        <div class="action-grid">
            <a class="panel action-card" href="{{ url('/admin/employees') }}">
                <strong>Manage Employees</strong>
                <span>Add, edit, and review staff records.</span>
            </a>
            <a class="panel action-card" href="{{ url('/admin/payroll') }}">
                <strong>Generate Payroll</strong>
                <span>Create pay runs by cutoff period.</span>
            </a>
            <a class="panel action-card" href="{{ url('/admin/payroll/history') }}">
                <strong>Payroll History</strong>
                <span>Review generated payroll records.</span>
            </a>
            <a class="panel action-card" href="{{ url('/admin/attendance') }}">
                <strong>Manage Attendance</strong>
                <span>Record and audit daily attendance.</span>
            </a>
            <a class="panel action-card" href="{{ url('/admin/deductions') }}">
                <strong>Manage Deductions</strong>
                <span>Apply benefits, late, and other deductions.</span>
            </a>
            <a class="panel action-card" href="{{ url('/admin/reports') }}">
                <strong>View Reports</strong>
                <span>See payroll and attendance summaries.</span>
            </a>
        </div>
    </section>

    @if(isset($latestPayroll) && $latestPayroll->count())
        <section class="panel">
            <div class="section-header">
                <h2>Latest Payroll</h2>
                <a class="btn btn-secondary" href="{{ url('/admin/payroll/history') }}">View all</a>
            </div>
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Net pay</th>
                            <th>Generated</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($latestPayroll as $pay)
                            <tr>
                                <td>{{ $pay->name ?? 'Employee #' . $pay->employee_id }}</td>
                                <td>PHP {{ number_format($pay->net_pay ?? 0, 2) }}</td>
                                <td>{{ $pay->generated_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    @endif
@endsection
