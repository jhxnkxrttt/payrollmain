@extends('layouts.app')

@section('title', 'Edit Employee - Cafe Payroll')
@section('page-title', 'Edit Employee')

@section('content')
    <section class="panel">
        <div class="section-header">
            <div>
                <h2>{{ $employee->name }}</h2>
                <p>Update position and compensation details.</p>
            </div>
            <a href="{{ url('/admin/employees') }}" class="btn btn-secondary">Back</a>
        </div>

        <form method="POST" action="{{ url('/admin/employees/update/' . $employee->id) }}" class="form-grid">
            @csrf

            <div class="form-row">
                <label for="name">Employee name</label>
                <input type="text" id="name" name="name" value="{{ $employee->name }}" required>
            </div>

            <div class="form-row">
                <label for="position">Position</label>
                <input type="text" id="position" name="position" value="{{ $employee->position }}" required>
            </div>

            <div class="form-row">
                <label for="monthly_salary">Monthly salary</label>
                <input type="number" id="monthly_salary" name="monthly_salary" value="{{ $employee->monthly_salary }}" min="0" step="0.01" required>
            </div>

            <div class="form-actions">
                <button type="submit">Update employee</button>
            </div>
        </form>
    </section>
@endsection
