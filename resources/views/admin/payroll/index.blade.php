@extends('layouts.app')

@section('title', 'Generate Payroll - Cafe Payroll')
@section('page-title', 'Generate Payroll')

@section('content')
    <section class="panel">
        <div class="section-header">
            <div>
                <h2>Payroll Run</h2>
                <p>Enter the employee's 15-day attendance summary, paid date, and selected deductions.</p>
            </div>
            <a href="{{ url('/admin/payroll/history') }}" class="btn btn-secondary">Payroll history</a>
        </div>

        <div class="payroll-list">
            @forelse($employees as $emp)
                @php
                    $employeeDeductions = $deductions->get($emp->id, collect());
                    $dailyRate = $emp->monthly_salary / 15;
                @endphp

                <article class="payroll-card">
                    <div class="payroll-card-header">
                        <div>
                            <h3>{{ $emp->name }}</h3>
                            <p>{{ $emp->position }} · PHP {{ number_format($emp->monthly_salary, 2) }} monthly</p>
                        </div>
                        <span class="badge badge-neutral">Daily rate: PHP {{ number_format($dailyRate, 2) }}</span>
                    </div>

                    <form method="POST" action="{{ url('/admin/payroll/generate/' . $emp->id) }}" class="payroll-form">
                        @csrf

                        <div class="form-row">
                            <label for="paid-date-{{ $emp->id }}">Salary paid date</label>
                            <input type="date" id="paid-date-{{ $emp->id }}" name="paid_date" required>
                        </div>

                        <div class="form-row">
                            <label for="present-days-{{ $emp->id }}">Days present within 15 days</label>
                            <input type="number" id="present-days-{{ $emp->id }}" name="present_days" min="0" max="15" value="15" required>
                        </div>

                        <div class="form-row">
                            <label for="absent-days-{{ $emp->id }}">Days absent within 15 days</label>
                            <input type="number" id="absent-days-{{ $emp->id }}" name="absent_days" min="0" max="15" value="0" required>
                        </div>

                        <div class="form-row">
                            <label for="late-days-{{ $emp->id }}">Times late within 15 days</label>
                            <input type="number" id="late-days-{{ $emp->id }}" name="late_days" min="0" max="15" value="0" required>
                        </div>

                        <div class="deduction-box">
                            <div class="deduction-box-header">
                                <strong>Deductions</strong>
                                <span>Checked deductions will be subtracted from gross pay.</span>
                            </div>

                            @forelse($employeeDeductions as $deduction)
                                <label class="checkbox-row" for="deduction-{{ $emp->id }}-{{ $deduction->id }}">
                                    <input
                                        type="checkbox"
                                        id="deduction-{{ $emp->id }}-{{ $deduction->id }}"
                                        name="deduction_ids[]"
                                        value="{{ $deduction->id }}"
                                    >
                                    <span>
                                        <strong>{{ $deduction->type }}</strong>
                                        <small>{{ $deduction->description ?: 'No description' }}</small>
                                    </span>
                                    <b>PHP {{ number_format($deduction->amount, 2) }}</b>
                                </label>
                            @empty
                                <p class="empty-note">No saved deductions for this employee.</p>
                            @endforelse
                        </div>

                        <div class="payroll-note">
                            Gross pay is based on present days. Each late count deducts 20% of the daily rate.
                        </div>

                        <button type="submit">Generate payroll</button>
                    </form>
                </article>
            @empty
                <section class="panel empty-state">
                    No employees available for payroll.
                </section>
            @endforelse
        </div>
    </section>
@endsection
