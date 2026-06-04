@extends('layouts.app')

@section('title', 'Sign In - Cafe Payroll')

@section('content')
    <main class="login-page">
        <section class="login-card" aria-labelledby="login-title">
            <div class="login-header">
                <div class="login-logo">CP</div>
                <h1 id="login-title">Cafe Payroll</h1>
                <p>Employee payroll management system</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="form-grid">
                @csrf

                <div class="form-row full">
                    <label for="email">Email address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="admin@cafe.com"
                        required
                        autofocus
                        value="{{ old('email') }}"
                    >
                    @error('email')
                        <span class="error-alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-row full">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        required
                    >
                    @error('password')
                        <span class="error-alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn">Sign in</button>
                </div>
            </form>

            <p class="login-footer">Demo credentials available upon request</p>
        </section>
    </main>
@endsection
