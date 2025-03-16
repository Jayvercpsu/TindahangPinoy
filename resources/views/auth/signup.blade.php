@extends('layouts.layout')

@section('title', 'Sign Up')

@section('content')
<!-- Breadcrumb -->
<div class="row">
    <div class="col">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sign Up</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Sign Up Form -->
<div class="row justify-content-center">
    <div class="col-md-6">
        <!-- Login & Sign Up Toggle Buttons -->
        <div class="d-flex justify-content-center mb-3">
            <a href="{{ route('login') }}" class="btn btn-primary me-2">Log In</a>
            <a href="{{ route('signup') }}" class="btn btn-outline-primary">Sign Up</a>
        </div>

        <div class="card">
            <div class="card-header text-center">Create an Account</div>
            <div class="card-body">
                <form method="POST" action="{{ route('signup.submit') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

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
                        <small id="passwordError" class="text-danger" style="display:none;">
                            Password must be at least 8 characters long and include an uppercase letter, a lowercase letter, a number, and a special character.
                        </small>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                        <small id="confirmPasswordError" class="text-danger" style="display:none;">
                            Passwords do not match.
                        </small>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                </form>
            </div>
        </div>

        <div class="text-center mt-3">
            Already have an account? <a href="{{ route('login') }}">Log in</a>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="statusSuccessModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body text-center p-lg-4">
                <h4 class="text-success mt-3">Success!</h4>
                <p class="mt-3">Your account has been created. Please log in.</p>
                <button type="button" class="btn btn-sm mt-3 btn-success" data-bs-dismiss="modal" onclick="redirectToLogin()">Ok</button>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="statusErrorsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body text-center p-lg-4">
                <h4 class="text-danger mt-3">Error!</h4>
                <p class="mt-3" id="errorMessage">An error occurred.</p>
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

    function redirectToLogin() {
        window.location.href = "{{ route('login') }}";
    }

    // Password validation on keyup
    document.getElementById('password').addEventListener('keyup', function() {
        let password = this.value;
        let errorMessage = document.getElementById('passwordError');
        let strongRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/;

        if (!strongRegex.test(password)) {
            errorMessage.style.display = "block";
            this.setCustomValidity("Password does not meet security requirements.");
        } else {
            errorMessage.style.display = "none";
            this.setCustomValidity("");
        }
    });

    // Check if passwords match
    document.getElementById('password_confirmation').addEventListener('keyup', function() {
        let password = document.getElementById('password').value;
        let confirmPassword = this.value;
        let errorMessage = document.getElementById('confirmPasswordError');

        if (password !== confirmPassword) {
            errorMessage.style.display = "block";
            this.setCustomValidity("Passwords do not match.");
        } else {
            errorMessage.style.display = "none";
            this.setCustomValidity("");
        }
    });

    // Show success modal if sign-up is successful
    @if(session('success'))
        document.addEventListener("DOMContentLoaded", function () {
            var successModal = new bootstrap.Modal(document.getElementById('statusSuccessModal'));
            successModal.show();
        });
    @endif

    // Show error modal if email or password errors exist
    @if($errors->has('email') || $errors->has('password') || $errors->has('password_confirmation') || session('error'))
        document.addEventListener("DOMContentLoaded", function () {
            var errorModal = new bootstrap.Modal(document.getElementById('statusErrorsModal'));
            var errorMessage = document.getElementById('errorMessage');

            @if($errors->has('email'))
                errorMessage.innerText = "This email is already registered.";
            @elseif($errors->has('password_confirmation'))
                errorMessage.innerText = "Passwords do not match.";
            @else
                errorMessage.innerText = "An error occurred.";
            @endif

            errorModal.show();
        });
    @endif
</script>
@endsection
