@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h2>Login</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login.user') }}">
        @csrf
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>

    <hr>

    <!-- Google Login Button -->
    <a href="{{ url('/auth/google') }}" class="btn btn-danger">
        <i class="fab fa-google"></i> Login with Google
    </a>

    <p>Don't have an account? <a href="{{ url('/register') }}">Sign Up</a></p>
</div>
@endsection
