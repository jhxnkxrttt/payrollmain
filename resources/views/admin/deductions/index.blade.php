@extends('layouts.app')

@section('title', 'Deductions - Cafe Payroll')
@section('page-title', 'Manage Deductions')

@section('content')
    <section class="panel">
        <div class="section-header">
            <div>
                <h2>Add Deduction</h2>
                <p>Apply standard or custom deductions to employee payroll.</p>
            </div>
        </div>

        <form method="POST" action="{{ url('/admin/deductions/store') }}" class="form-grid">
            @csrf

            <div class="form-row">
                <label for="employee_id">Employee</label>
                <select name="employee_id" id="employee_id" required>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-row">
                <label for="type">Type</label>
                <select name="type" id="type" required>
                    <option value="">Select type</option>
                    <option value="SSS">SSS</option>
                    <option value="Pag-IBIG">Pag-IBIG</option>
                    <option value="PhilHealth">PhilHealth</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="form-row">
                <label for="description">Description</label>
                <input type="text" name="description" id="description">
            </div>

            <div class="form-actions">
                <button type="submit">Save deduction</button>
            </div>
        </form>
    </section>

    <section class="panel">
        <div class="section-header">
            <div>
                <h2>Deduction List</h2>
                <p>All deductions currently recorded in the system.</p>
            </div>
        </div>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Description</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($deductions as $d)
                        <tr>
                            <td>{{ $d->name }}</td>
                            <td>{{ $d->type }}</td>
                            <td>PHP {{ number_format($d->amount, 2) }}</td>
                            <td>{{ $d->description ?? '---' }}</td>
                            <td>{{ $d->created_at }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-state">No deductions recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
