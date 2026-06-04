<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Cafe Payroll System')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('styles')
</head>
<body>
    @php
        $role = session('role');
        $isAdmin = $role === 'admin';
        $isLoggedIn = session()->has('user_id');
        $dashboardUrl = $isAdmin ? url('/admin/dashboard') : url('/employee/dashboard');
        $pageEyebrow = $isAdmin ? 'Admin Workspace' : 'Employee Portal';
    @endphp

    @if($isLoggedIn)
        <div class="app-shell">
            <aside class="sidebar">
                <a class="sidebar-brand" href="{{ $dashboardUrl }}" aria-label="Cafe Payroll dashboard">
                    <span class="brand-mark">CP</span>
                    <span>
                        <strong>Cafe Payroll</strong>
                        <small>{{ $isAdmin ? 'Operations' : 'Staff' }}</small>
                    </span>
                </a>

                <nav class="sidebar-nav" aria-label="Main navigation">
                    <a href="{{ $dashboardUrl }}" class="sidebar-item {{ request()->is('admin/dashboard') || request()->is('employee/dashboard') ? 'active' : '' }}">
                        <span class="nav-icon">DB</span>
                        Dashboard
                    </a>

                    @if($isAdmin)
                        <a href="{{ url('/admin/employees') }}" class="sidebar-item {{ request()->is('admin/employees*') ? 'active' : '' }}">
                            <span class="nav-icon">EM</span>
                            Employees
                        </a>
                        <a href="{{ url('/admin/payroll') }}" class="sidebar-item {{ request()->is('admin/payroll*') ? 'active' : '' }}">
                            <span class="nav-icon">PR</span>
                            Payroll
                        </a>
                        <a href="{{ url('/admin/attendance') }}" class="sidebar-item {{ request()->is('admin/attendance*') ? 'active' : '' }}">
                            <span class="nav-icon">AT</span>
                            Attendance
                        </a>
                        <a href="{{ url('/admin/deductions') }}" class="sidebar-item {{ request()->is('admin/deductions*') ? 'active' : '' }}">
                            <span class="nav-icon">DD</span>
                            Deductions
                        </a>
                        <a href="{{ url('/admin/reports') }}" class="sidebar-item {{ request()->is('admin/reports*') ? 'active' : '' }}">
                            <span class="nav-icon">RP</span>
                            Reports
                        </a>
                    @else
                        <a href="{{ url('/employee/profile') }}" class="sidebar-item {{ request()->is('employee/profile') ? 'active' : '' }}">
                            <span class="nav-icon">PF</span>
                            Profile
                        </a>
                        <a href="{{ url('/employee/payslips') }}" class="sidebar-item {{ request()->is('employee/payslips') ? 'active' : '' }}">
                            <span class="nav-icon">PS</span>
                            Payslips
                        </a>
                        <a href="{{ url('/employee/attendance') }}" class="sidebar-item {{ request()->is('employee/attendance') ? 'active' : '' }}">
                            <span class="nav-icon">AT</span>
                            Attendance
                        </a>
                    @endif
                </nav>

                <a class="sidebar-item sidebar-logout" href="{{ url('/logout') }}">
                    <span class="nav-icon">LO</span>
                    Logout
                </a>
            </aside>

            <main class="main-content">
                <header class="topbar">
                    <div>
                        <span class="eyebrow">{{ $pageEyebrow }}</span>
                        <h1>@yield('page-title', 'Dashboard')</h1>
                    </div>
                    <div class="user-chip">
                        <span>{{ ucfirst($role ?? 'user') }}</span>
                        <span class="avatar">{{ strtoupper(substr($role ?? 'U', 0, 1)) }}</span>
                    </div>
                </header>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Please review the following:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <section class="page-content">
                    @yield('content')
                </section>
            </main>
        </div>
    @else
        @yield('content')
    @endif

    @yield('scripts')
</body>
</html>
