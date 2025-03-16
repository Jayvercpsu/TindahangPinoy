@extends('layouts.layout')

@section('title', 'Log In')

@section('content')
<!-- Breadcrumb -->
<div class="row">
    <div class="col">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Log In</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Log In Form -->
<div class="row justify-content-center">
    <div class="col-md-6">
        <!-- Login & Sign Up Toggle Buttons -->
        <div class="d-flex justify-content-center mb-3">
            <a href="{{ route('login') }}" class="btn btn-primary me-2">Log In</a>
            <a href="{{ route('signup') }}" class="btn btn-outline-primary">Sign Up</a>
        </div>

        <div class="card">
            <div class="card-header text-center">Log In to Your Account</div>
            <div class="card-body">
                <form method="POST" action="{{ route('login.submit') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>
                        <a href="{{ route('password.request') }}">Forgot your password?</a>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Log In</button>
                </form>
            </div>
        </div>

        <div class="text-center mt-3">
            Don't have an account? <a href="{{ route('signup') }}">Sign Up</a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function togglePassword(id) {
    let input = document.getElementById(id);
    input.type = input.type === "password" ? "text" : "password";
}
</script>
@endsection
