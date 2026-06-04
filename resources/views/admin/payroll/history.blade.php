@extends('layouts.app')

@section('title', 'Payroll History - Cafe Payroll')
@section('page-title', 'Payroll History')

@section('content')
    <section class="panel chart-panel">
        <div class="section-header">
            <div>
                <h2>Salary Analytics</h2>
                <p>Net salary trend per employee based on generated payroll records.</p>
            </div>
        </div>

        @if(($salarySeries ?? collect())->count())
            <div class="chart-frame large">
                <canvas
                    class="salary-multi-line-chart"
                    data-series='@json($salarySeries)'
                ></canvas>
            </div>
        @else
            <div class="empty-state compact">No salary analytics yet. Generate payroll to populate the chart.</div>
        @endif
    </section>

    <section class="panel">
        <div class="section-header">
            <div>
                <h2>Generated Payroll</h2>
                <p>Review paid salary records, attendance basis, and deductions.</p>
            </div>
            <a href="{{ url('/admin/payroll') }}" class="btn">Generate payroll</a>
        </div>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Paid date</th>
                        <th>Attendance</th>
                        <th>Gross pay</th>
                        <th>Deductions</th>
                        <th>Net pay</th>
                        <th>Date generated</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payrolls as $pay)
                        @php
                            $selectedDeductions = json_decode($pay->selected_deductions ?? '[]', true) ?: [];
                        @endphp
                        <tr>
                            <td>
                                <strong>{{ $pay->name }}</strong>
                                <br>
                                <span class="text-muted">{{ $pay->position }}</span>
                            </td>
                            <td>{{ $pay->paid_date ?? 'Not set' }}</td>
                            <td>
                                Present: {{ $pay->present_days ?? $pay->total_days }}<br>
                                Absent: {{ $pay->absent_days ?? 0 }}<br>
                                Late: {{ $pay->late_days ?? 0 }}
                            </td>
                            <td>PHP {{ number_format($pay->gross_pay, 2) }}</td>
                            <td>
                                <strong>PHP {{ number_format($pay->total_deductions, 2) }}</strong>
                                <br>
                                <span class="text-muted">Late: PHP {{ number_format($pay->late_deduction ?? 0, 2) }}</span>
                                @foreach($selectedDeductions as $deduction)
                                    <br>
                                    <span class="text-muted">
                                        {{ $deduction['type'] }}: PHP {{ number_format($deduction['amount'], 2) }}
                                    </span>
                                @endforeach
                            </td>
                            <td><strong>PHP {{ number_format($pay->net_pay, 2) }}</strong></td>
                            <td>{{ $pay->generated_at }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-state">No payroll has been generated yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
