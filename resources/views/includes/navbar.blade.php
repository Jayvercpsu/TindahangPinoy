<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand" href="{{ route('index') }}">Simple Ecommerce</a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <div class="d-flex flex-column flex-md-row w-100 justify-content-between align-items-center">
                <!-- Left Menu -->
                <ul class="navbar-nav text-center text-md-start">
                    <li class="nav-item"><a class="nav-link" href="{{ route('index') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('product') }}">Product</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>
                </ul>

                <!-- Search -->
                <form class="d-flex my-2 my-lg-0 mx-auto">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" placeholder="Search...">
                        <button type="submit" class="btn btn-secondary">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>

                <!-- Cart & Logout Section -->
                <div class="d-flex align-items-center mt-3 mt-md-0">
                    <!-- Cart -->
                    <a class="btn btn-success btn-sm me-2" href="{{ route('cart') }}">
                        <i class="fa fa-shopping-cart"></i> Cart
                        <span class="badge badge-light">3</span>
                    </a>

                    @if(Auth::check())
                    <!-- Logout Button (Triggers Modal) -->
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#logoutConfirmModal">
                        Logout
                    </button>
                    @else
                    <!-- Sign Up -->
                    <a href="{{ route('signup') }}" class="btn btn-primary btn-sm">Sign Up</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutConfirmModal" tabindex="-1" role="dialog" aria-labelledby="logoutConfirmLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutConfirmLabel">Confirm Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <i class="fa fa-exclamation-circle text-warning" style="font-size: 2rem;"></i>
                <p class="mt-3">Are you sure you want to logout?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>
