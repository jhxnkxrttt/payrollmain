@extends('layouts.app')

@section('title', 'Attendance - Cafe Payroll')
@section('page-title', 'My Attendance')

@section('content')
    <section class="panel">
        <div class="section-header">
            <div>
                <h2>Attendance History</h2>
                <p>Your recorded time in, time out, and attendance status.</p>
            </div>
        </div>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time in</th>
                        <th>Time out</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td>{{ $log->date }}</td>
                            <td>{{ $log->time_in ?? '---' }}</td>
                            <td>{{ $log->time_out ?? '---' }}</td>
                            <td>
                                <span class="badge {{ $log->status === 'present' ? 'badge-success' : ($log->status === 'late' ? 'badge-warning' : 'badge-danger') }}">
                                    {{ $log->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="empty-state">No attendance records yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
