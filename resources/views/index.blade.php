<!-- ✅ Include necessary styles -->
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/contacts/contact-1/assets/css/contact-1.css">


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{ asset('css/styles.css') }}" rel="stylesheet">

@include('includes.navbar')
@include('includes.introduction')

<div class="container mt-3">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>

<!-- ✅ Breadcrumb -->
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mt-3">
            <li class="breadcrumb-item active" aria-current="page">Home</li>
        </ol>
    </nav>
</div>

<!-- ✅ Main Content -->
<div class="container mt-4">
    <div class="row">
        <!-- 🔍 Search Bar -->
        <div class="col-12 mb-3">
            <form method="GET" action="{{ route('product.search') }}">
                <div class="input-group">
                    <input type="text" name="query" class="form-control" placeholder="Search products..." value="{{ request('query') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="fa fa-search"></i> Search
                    </button>
                </div>
            </form>
        </div>

        <!-- 🔹 Sidebar - Latest Products -->
        <aside class="col-md-3 mb-3">
            <div class="card">
                <div class="card-header bg-primary text-white text-uppercase">
                    <i class="fa fa-clock-o"></i> Latest Products
                </div>
                <div class="list-group list-group-flush" style="max-height: 300px; overflow-y: auto;">
                    @foreach ($latestProducts as $latest)
                    <li class="list-group-item d-flex align-items-center">
                        <img src="{{ $latest->image_url ?? 'https://dummyimage.com/50x50/ccc/fff' }}"
                            alt="{{ $latest->name }}"
                            class="img-thumbnail me-2"
                            width="50">
                        <a href="{{ route('product.show', $latest->id) }}" class="text-decoration-none">{{ $latest->name }}</a>
                    </li>
                    @endforeach
                </div>
            </div>
        </aside>

        <!-- 🔹 Main Product Grid -->
        <section class="col-md-9">
            <div class="row">
                @if ($products->isEmpty())
                <div class="col-12 text-center">
                    <p class="alert alert-warning">No products found.</p>
                </div>
                @else
                @foreach ($products as $product)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <!-- Product Image -->
                        <img src="{{ asset('storage/' . $product->image) ?? 'https://dummyimage.com/600x400/ccc/fff' }}"
                            alt="{{ $product->name }}"
                            class="card-img-top"
                            style="height: 250px; object-fit: cover;">

                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('product.show', $product->id) }}"
                                    class="text-dark text-decoration-none fw-bold">
                                    {{ $product->name }}
                                </a>
                            </h5>
                            <p class="card-text text-muted">
                                {{ Str::limit($product->description, 80) }}
                            </p>

                            <!-- Price & Buttons -->
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="text-danger fw-bold">₱{{ number_format($product->price, 2) }}</span>
                            </div>
                        </div>

                        <!-- View & Add to Cart Buttons -->
                        <div class="card-footer bg-white d-flex justify-content-between">
                            <a href="{{ route('product.show', $product->id) }}"
                                class="btn btn-outline-primary btn-sm">
                                <i class="fa fa-eye"></i> View Product
                            </a>
                            <button class="btn btn-success btn-sm add-to-cart"
                                data-bs-toggle="modal"
                                data-bs-target="#addToCartModal"
                                data-id="{{ $product->id }}"
                                data-name="{{ $product->name }}"
                                data-image="{{ asset('storage/' . $product->image) }}"
                                data-price="{{ $product->price }}"
                                data-stock="{{ $product->stock }}"> <!-- Added stock attribute -->
                                <i class="fa fa-shopping-cart"></i> Add to Cart
                            </button>

                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </section>

    </div>
</div>


<!-- Add to Cart Modal -->
<div class="modal fade" id="addToCartModal" tabindex="-1" aria-labelledby="addToCartModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addToCartModalLabel">Add to Cart</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <img id="modalProductImage" src="" class="img-fluid mb-3" style="max-height: 200px;">
                </div>
                <h5 id="modalProductName"></h5>
                <p id="modalProductPrice" class="text-muted"></p>
                <p id="modalProductStock" class="text-muted"></p> <!-- ✅ Added stock display -->

                <form id="addToCartForm" method="POST" action="{{ route('cart.add') }}">
                    @csrf
                    <input type="hidden" name="product_id" id="modalProductId">

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" name="quantity" id="modalQuantity" class="form-control" value="1" min="1" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Add to Cart</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- ✅ Footer -->
@include('includes.footer')

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const modal = document.getElementById("addToCartModal");
        const productImage = document.getElementById("modalProductImage");
        const productName = document.getElementById("modalProductName");
        const productPrice = document.getElementById("modalProductPrice");
        const productStock = document.getElementById("modalProductStock");
        const productId = document.getElementById("modalProductId");
        const quantityInput = document.getElementById("modalQuantity");
        const addToCartButton = document.querySelector("#addToCartForm button[type='submit']");

        document.querySelectorAll(".add-to-cart").forEach(button => {
            button.addEventListener("click", function () {
                const stock = parseInt(this.getAttribute("data-stock"));

                productImage.src = this.getAttribute("data-image");
                productName.textContent = this.getAttribute("data-name");
                productPrice.textContent = "Price: ₱" + parseFloat(this.getAttribute("data-price")).toFixed(2);
                productStock.textContent = "Stock: " + stock;
                productId.value = this.getAttribute("data-id");

                // Reset quantity to 1 on open
                quantityInput.value = 1;

                // Handle stock logic
                if (stock === 0) {
                    quantityInput.disabled = true;
                    addToCartButton.disabled = true;
                    quantityInput.value = 0;
                } else {
                    quantityInput.disabled = false;
                    addToCartButton.disabled = false;

                    quantityInput.addEventListener("input", function () {
                        const enteredQty = parseInt(this.value) || 0;

                        if (enteredQty > stock || enteredQty <= 0) {
                            addToCartButton.disabled = true;
                            this.classList.add("is-invalid");
                        } else {
                            addToCartButton.disabled = false;
                            this.classList.remove("is-invalid");
                        }
                    });
                }
            });
        });
    });
</script>


<script>
    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>