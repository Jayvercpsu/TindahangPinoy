<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand" href="{{ route('index') }}">Simple Ecommerce</a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse justify-content-between" id="navbarContent">

            <!-- Left Menu -->
            <ul class="navbar-nav m-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('index') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('product') }}">Product</a></li> 
                <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>
            </ul>

            <!-- Search, Cart & Sign Up Section -->
            <div class="d-flex align-items-center">
                <!-- Search -->
                <form class="form-inline my-2 my-lg-0 mr-2">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" placeholder="Search...">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary btn-number">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Cart -->
                <a class="btn btn-success btn-sm mx-2" href="{{ route('cart') }}">
                    <i class="fa fa-shopping-cart"></i> Cart
                    <span class="badge badge-light">3</span>
                </a>

                @if(Auth::check())
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                </form>
                @else 
                <a href="{{ route('signup') }}" class="btn btn-primary btn-sm">Sign Up</a>
                @endif


            </div>

        </div>
    </div>
</nav>