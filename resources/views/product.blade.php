<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/contacts/contact-1/assets/css/contact-1.css">


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<link href="{{ asset('css/styles.css') }}" rel="stylesheet">

@include('includes.navbar');


<div class="container">
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Product</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="container py-5">
    <h2 class="text-center mb-4">Our Products</h2>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        <!-- Product 1 -->
        <div class="col">
            <div class="card h-100 shadow-sm">
                <img src="https://images.unsplash.com/photo-1598618826732-fb2fdf367775?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w0NzEyNjZ8MHwxfHNlYXJjaHw1fHxzbWFydHBob25lfGVufDB8MHx8fDE3MjEzMDU4NTZ8MA&ixlib=rb-4.0.3&q=80&w=1080" class="card-img-top" alt="Product 1">
                <div class="card-body">
                    <h5 class="card-title">Product 1</h5>
                    <p class="card-text">A brief description of Product 1 and its features.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h5 mb-0">$19.99</span>
                        <button class="btn btn-outline-primary"><i class="bi bi-cart-plus"></i> Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product 2 -->
        <div class="col">
            <div class="card h-100 shadow-sm">
                <img src="https://images.unsplash.com/photo-1720048171731-15b3d9d5473f?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w0NzEyNjZ8MXwxfHNlYXJjaHwxfHxzbWFydHBob25lfGVufDB8MHx8fDE3MjEzMDU4NTZ8MA&ixlib=rb-4.0.3&q=80&w=1080" class="card-img-top" alt="Product 2">
                <div class="card-body">
                    <h5 class="card-title">Product 2</h5>
                    <p class="card-text">A brief description of Product 2 and its features.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h5 mb-0">$24.99</span>
                        <button class="btn btn-outline-primary"><i class="bi bi-cart-plus"></i> Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product 3 -->
        <div class="col">
            <div class="card h-100 shadow-sm">
                <img src="https://images.unsplash.com/photo-1600087626120-062700394a01?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w0NzEyNjZ8MHwxfHNlYXJjaHw2fHxzbWFydHBob25lfGVufDB8MHx8fDE3MjEzMDU4NTZ8MA&ixlib=rb-4.0.3&q=80&w=1080" class="card-img-top" alt="Product 3">
                <div class="card-body">
                    <h5 class="card-title">Product 3</h5>
                    <p class="card-text">A brief description of Product 3 and its features.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h5 mb-0">$29.99</span>
                        <button class="btn btn-outline-primary"><i class="bi bi-cart-plus"></i> Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product 4 -->
        <div class="col">
            <div class="card h-100 shadow-sm">
                <img src="https://images.unsplash.com/photo-1598965402089-897ce52e8355?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w0NzEyNjZ8MHwxfHNlYXJjaHw0fHxzbWFydHBob25lfGVufDB8MHx8fDE3MjEzMDU4NTZ8MA&ixlib=rb-4.0.3&q=80&w=1080" class="card-img-top" alt="Product 4">
                <div class="card-body">
                    <h5 class="card-title">Product 4</h5>
                    <p class="card-text">A brief description of Product 4 and its features.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h5 mb-0">$34.99</span>
                        <button class="btn btn-outline-primary"><i class="bi bi-cart-plus"></i> Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 

@include('includes.footer');

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>