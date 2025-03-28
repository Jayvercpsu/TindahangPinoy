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
                        <a href="#" class="btn btn-success btn-sm add-to-cart" data-id="{{ $product->id }}">
                            <i class="fa fa-shopping-cart"></i> Add to Cart
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
</section>

    </div>
</div>

<!-- ✅ Footer -->
@include('includes.footer')

<!-- ✅ Scripts -->
<script>
    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>