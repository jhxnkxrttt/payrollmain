@extends('layouts.app')

@section('title', 'Attendance - Cafe Payroll')
@section('page-title', 'Manage Attendance')

@section('content')
    <section class="panel">
        <div class="section-header">
            <div>
                <h2>Add Attendance</h2>
                <p>Record time and attendance status for an employee.</p>
            </div>
        </div>

        <form method="POST" action="{{ url('/admin/attendance/store') }}" class="form-grid">
            @csrf

            <div class="form-row">
                <label for="employee_id">Employee</label>
                <select id="employee_id" name="employee_id" required>
                    <option value="">Select employee</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-row">
                <label for="date">Date</label>
                <input type="date" id="date" name="date" required>
            </div>

            <div class="form-row">
                <label for="time_in">🟢 Time In</label>
                <input type="time" id="time_in" name="time_in" class="time-input">
            </div>

            <div class="form-row">
                <label for="time_out">🔴 Time Out</label>
                <input type="time" id="time_out" name="time_out" class="time-input">
            </div>
            
            <div class="form-row">
                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="" selected>Select status</option>
                    <option value="absent">Absent</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit">Save attendance</button>
            </div>
        </form>
    </section>

    <section class="panel">
        <div class="section-header">
            <div>
                <h2>Attendance Records</h2>
                <p>Recent attendance entries across the team.</p>
            </div>
        </div>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Position</th>
                        <th>Date</th>
                        <th>Time in</th>
                        <th>Time out</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendance as $a)
                        <tr>
                            <td>{{ $a->name }}</td>
                            <td>{{ $a->position }}</td>
                            <td>{{ $a->date }}</td>
                            <td>{{ $a->time_in ?? '---' }}</td>
                            <td>{{ $a->time_out ?? '---' }}</td>
                            <td>
                                <span class="badge {{ $a->status === 'present' ? 'badge-success' : ($a->status === 'late' ? 'badge-warning' : 'badge-danger') }}">
                                    {{ $a->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">No attendance records yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
