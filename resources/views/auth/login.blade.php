@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-5 col-sm-8 col-10 mx-auto">
        <div class="card shadow-lg border-0 rounded-lg p-4">
            <h2 class="text-center mb-3">Login</h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('login.user') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required style="height: 45px;">
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required style="height: 45px;">
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>

            <hr>

            <!-- Google Login Button -->
            <a href="{{ url('/auth/google') }}" class="btn btn-danger w-100">
                <i class="fab fa-google me-2"></i> Login with Google
            </a>

            <p class="mt-3 text-center">
                Don't have an account? <a href="{{ url('/register') }}" class="text-decoration-none">Sign Up</a>
            </p>
        </div>
    </div>
</div>
@endsection
