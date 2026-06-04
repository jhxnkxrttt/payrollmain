@extends('layouts.app')

@section('title', 'Employees - Cafe Payroll')
@section('page-title', 'Employees')

@section('content')
    <section class="panel">
        <div class="section-header">
            <div>
                <h2>Employee Directory</h2>
                <p>{{ $employees->count() }} employee records in the system.</p>
            </div>
            <a href="{{ url('/admin/employees/create') }}" class="btn">Add employee</a>
        </div>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Salary</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $emp)
                        <tr>
                            <td>{{ $emp->id }}</td>
                            <td>{{ $emp->name }}</td>
                            <td>{{ $emp->position }}</td>
                            <td>PHP {{ number_format($emp->monthly_salary, 2) }}</td>
                            <td>
                                <div class="inline-actions">
                                    <a class="btn btn-secondary" href="{{ url('/admin/employees/edit/' . $emp->id) }}">Edit</a>
                                    <a class="btn btn-danger" href="{{ url('/admin/employees/delete/' . $emp->id) }}">Delete</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-state">No employees yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
