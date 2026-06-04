@extends('layouts.app')

@section('title', 'Payslips - Cafe Payroll')
@section('page-title', 'My Payslips')

@section('content')
    <section class="card-grid">
        @forelse($payslips as $p)
            @php
                $selectedDeductions = json_decode($p->selected_deductions ?? '[]', true) ?: [];
            @endphp
            <article class="panel">
                <div class="section-header">
                    <div>
                        <h2>Paid {{ $p->paid_date ?? 'Not set' }}</h2>
                        <p>Generated {{ $p->generated_at }}</p>
                    </div>
                </div>
                <dl class="detail-list">
                    <div>
                        <dt>Present days</dt>
                        <dd>{{ $p->present_days ?? $p->total_days }}</dd>
                    </div>
                    <div>
                        <dt>Absent days</dt>
                        <dd>{{ $p->absent_days ?? 0 }}</dd>
                    </div>
                    <div>
                        <dt>Times late</dt>
                        <dd>{{ $p->late_days ?? 0 }}</dd>
                    </div>
                    <div>
                        <dt>Gross pay</dt>
                        <dd>PHP {{ number_format($p->gross_pay, 2) }}</dd>
                    </div>
                    <div>
                        <dt>Late deduction</dt>
                        <dd>PHP {{ number_format($p->late_deduction ?? 0, 2) }}</dd>
                    </div>
                    @foreach($selectedDeductions as $deduction)
                        <div>
                            <dt>{{ $deduction['type'] }}</dt>
                            <dd>PHP {{ number_format($deduction['amount'], 2) }}</dd>
                        </div>
                    @endforeach
                    <div>
                        <dt>Total deductions</dt>
                        <dd>PHP {{ number_format($p->total_deductions, 2) }}</dd>
                    </div>
                    <div>
                        <dt>Net pay</dt>
                        <dd><strong>PHP {{ number_format($p->net_pay, 2) }}</strong></dd>
                    </div>
                    <a href="{{ route('payslip.download', $p->id) }}" class="btn btn-primary">
                    Download PDF
                    </a>
                </dl>
            </article>
        @empty
            <section class="panel empty-state">
                No payslips are available yet.
            </section>
        @endforelse
    </section>
@endsection
