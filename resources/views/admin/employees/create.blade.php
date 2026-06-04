@extends('layouts.app')

@section('title', 'Add Employee - Cafe Payroll')
@section('page-title', 'Add Employee')

@section('content')
    <section class="panel">
        <div class="section-header">
            <div>
                <h2>New Employee</h2>
                <p>Create the employee profile and login account.</p>
            </div>
            <a href="{{ url('/admin/employees') }}" class="btn btn-secondary">Back</a>
        </div>

        <form method="POST" action="{{ url('/admin/employees/store') }}" class="form-grid">
            @csrf

            <div class="form-row">
                <label for="name">Employee name</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-row">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-row">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-row">
                <label for="position">Position</label>
                <input type="text" id="position" name="position" required>
            </div>

            <div class="form-row">
                <label for="monthly_salary">Monthly salary</label>
                <input type="number" id="monthly_salary" name="monthly_salary" min="0" step="0.01" required>
            </div>

            <div class="form-row">
                <label for="hire_date">Hire date</label>
                <input type="date" id="hire_date" name="hire_date" required>
            </div>

            <div class="form-actions">
                <button type="submit">Save employee</button>
            </div>
        </form>
    </section>
@endsection
