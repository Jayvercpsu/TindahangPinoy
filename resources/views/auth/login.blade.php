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

<!-- Login Success Modal -->
<div class="modal fade" id="loginSuccessModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body text-center p-lg-4">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                    <circle class="path circle" fill="none" stroke="#198754" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1" />
                    <polyline class="path check" fill="none" stroke="#198754" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5" />
                </svg>
                <h4 class="text-success mt-3">Success!</h4>
                <p class="mt-3">You have successfully logged in.</p>
                <button type="button" class="btn btn-sm mt-3 btn-success" data-bs-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>

<!-- Logout Success Modal -->
<div class="modal fade" id="logoutSuccessModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body text-center p-lg-4">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                    <circle class="path circle" fill="none" stroke="#198754" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1" />
                    <polyline class="path check" fill="none" stroke="#198754" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5" />
                </svg>
                <h4 class="text-success mt-3">Success!</h4>
                <p class="mt-3">You have successfully logged out.</p>
                <button type="button" class="btn btn-sm mt-3 btn-success" data-bs-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="loginErrorModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body text-center p-lg-4">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                    <circle class="path circle" fill="none" stroke="#db3646" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1" />
                    <line class="path line" fill="none" stroke="#db3646" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3" />
                    <line class="path line" fill="none" stroke="#db3646" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="95.8" y1="38" x2="34.4" y2="92.2" />
                </svg>
                <h4 class="text-danger mt-3">Error!</h4>
                <p class="mt-3">Invalid email or password.</p>
                <button type="button" class="btn btn-sm mt-3 btn-danger" data-bs-dismiss="modal">Ok</button>
            </div>
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

// Show success modal if login is successful
@if(session('success') && session('success') === 'Logged in successfully!')
    document.addEventListener("DOMContentLoaded", function () {
        var successModal = new bootstrap.Modal(document.getElementById('loginSuccessModal'));
        successModal.show();
    });
@endif

// Show success modal if logout is successful
@if(session('success') && session('success') === 'Logged out successfully.')
    document.addEventListener("DOMContentLoaded", function () {
        var logoutModal = new bootstrap.Modal(document.getElementById('logoutSuccessModal'));
        logoutModal.show();
    });
@endif

// Show error modal if login fails
@if($errors->has('login'))
    document.addEventListener("DOMContentLoaded", function () {
        var errorModal = new bootstrap.Modal(document.getElementById('loginErrorModal'));
        errorModal.show();
    });
@endif
</script>
@endsection
