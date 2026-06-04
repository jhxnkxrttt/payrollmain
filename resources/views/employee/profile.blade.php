@extends('layouts.app')

@section('title', 'Profile - Cafe Payroll')
@section('page-title', 'Employee Profile')

@section('content')
    <div class="info-grid">
        <section class="panel">
            <div class="section-header">
                <h2>Personal Info</h2>
            </div>
            <dl class="detail-list">
                <div>
                    <dt>Name</dt>
                    <dd>{{ $employee->name ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt>Position</dt>
                    <dd>{{ $employee->position ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt>Salary</dt>
                    <dd>PHP {{ number_format($employee->monthly_salary ?? 0, 2) }}</dd>
                </div>
                <div>
                    <dt>Status</dt>
                    <dd><span class="badge badge-success">{{ $employee->status ?? 'N/A' }}</span></dd>
                </div>
            </dl>
        </section>

        <section class="panel">
            <div class="section-header">
                <h2>Account Info</h2>
            </div>
            <dl class="detail-list">
                <div>
                    <dt>Email</dt>
                    <dd>{{ $user->email ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt>Role</dt>
                    <dd>{{ $user->role ?? 'N/A' }}</dd>
                </div>
            </dl>
        </section>
    </div>
@endsection
