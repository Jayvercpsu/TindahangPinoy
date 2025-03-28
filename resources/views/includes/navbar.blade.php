<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand" href="{{ route('index') }}">Tindahang Pinoy</a>

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

                <!-- Cart & User Profile -->
                <div class="d-flex align-items-center mt-3 mt-md-0">
                    <!-- Cart -->
                    <a class="btn btn-success btn-sm me-2" href="{{ route('cart.index') }}">
                        <i class="fa fa-shopping-cart"></i> Cart
                        <span class="badge badge-light cart-count">
                            {{ auth()->check() ? \App\Models\Cart::where('user_id', auth()->id())->distinct('product_id')->count() : 0 }}
                        </span>


                    </a>

                    @if(Auth::check())
                    <!-- User Profile Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-outline-light btn-sm dropdown-toggle d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown">
                            <!-- Profile Image -->
                            <img src="{{ Auth::user()->profile_image ?? asset('default-profile.png') }}" class="rounded-circle me-2" width="30" height="30" alt="Profile">
                            {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="#">My Account</a></li>
                            <li>
                                <!-- Logout Button (Triggers Modal) -->
                                <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#logoutConfirmModal">
                                    Logout
                                </button>
                            </li>
                        </ul>
                    </div>
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
<div class="modal fade" id="logoutConfirmModal" tabindex="-1" aria-labelledby="logoutConfirmLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
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

<script>
    $(document).on('click', '.add-to-cart-btn', function(e) {
        e.preventDefault();

        let productId = $(this).data('id'); // Get product ID

        $.ajax({
            url: "{{ route('cart.add') }}",
            method: "POST",
            data: {
                product_id: productId,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.success) {
                    $(".cart-count").text(response.cart_count); // Update cart count to show unique products
                    alert(response.message);
                }
            },
            error: function() {
                alert("Error adding to cart.");
            }
        });
    });
</script>

<!-- Bootstrap JS (Ensure it's included) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>