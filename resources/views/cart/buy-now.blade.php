@extends('layouts.layout')

@push('styles')
<!-- Include DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<!-- <link rel="stylesheet" href="{{ asset('css/buy-now.css') }}"> -->


@endpush

@section('content')
<div class="container checkout-container" style="margin-top: 70px;">
    <!-- 🛑 Back to Cart Button -->
    <a href="{{ route('cart.index') }}" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Back to Cart
    </a>

    <h2 class="my-4 text-center">Checkout</h2>

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="row justify-content-center">
        <!-- 📍 Shipping Address -->
        <div class="col-md-6 section-spacing">
            <h4 class="mb-3 text-center">📍 Shipping Address</h4>
            <div class="address-card">
                @if($address)
                <div class="address-details">
                    <p><strong>Address:</strong> {{ $address->address }}</p>
                    <p><strong>City:</strong> {{ $address->city }}</p>
                    <p><strong>State:</strong> {{ $address->state }}</p>
                    <p><strong>Zip Code:</strong> {{ $address->zip_code }}</p>
                </div>
                <div class="address-actions">
                    <a href="{{ route('account.addresses') }}" class="btn btn-primary">Edit Address</a>
                    <a href="{{ route('account.addresses.view', $address->id) }}" class="btn btn-info">View Address</a>
                </div>
                @else
                <div class="alert alert-warning">
                    <strong>⚠ Please fill in your address first.</strong>
                    <span class="arrow">⬇</span>
                </div>
                <a href="{{ route('account.addresses') }}" class="btn btn-danger">Fill Address</a>
                @endif
            </div>
        </div>

        <!-- 💳 Payment Section -->
        <div class="col-md-6 section-spacing">
            <h4 class="mb-3 text-center">💳 Payment Method</h4>
            <div class="payment-card">
                <form action="{{ route('order.place') }}" method="POST">
                    @csrf
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" value="cod" checked>
                        <label class="form-check-label">Cash on Delivery (COD)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" value="gcash">
                        <label class="form-check-label">GCash Payment</label>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-success w-100" {{ !$address ? 'disabled' : '' }}>
                            Confirm Order
                        </button>
                        @if(!$address)
                        <small class="text-danger mt-2 d-block">Please add an address to proceed</small>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="order-summary">
        <h4 class="mt-4 text-center">🛍 Order Summary</h4>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    @php $grandTotal = 0; @endphp
                    @foreach($cartItems as $item)
                    @php
                    $totalPrice = $item->quantity * $item->product->price;
                    $grandTotal += $totalPrice;
                    @endphp
                    <tr>
                        <td><img src="{{ asset('storage/' . $item->product->image) }}" class="img-thumbnail" width="50"></td>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>₱{{ number_format($totalPrice, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-dark">
                    <tr>
                        <td colspan="3" class="text-end"><strong>Total Amount:</strong></td>
                        <td><strong id="grandTotalAmount">₱{{ number_format($grandTotal, 2) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        // Update Grand Total based on selected items in the cart
        function updateTotal() {
            let total = 0;
            let anyChecked = false;

            $('.item-checkbox:checked').each(function() {
                total += parseFloat($(this).data('price'));
                anyChecked = true;
            });

            // Update displayed total
            $('#grandTotalAmount').text('₱' + total.toFixed(2));
        }

        // When cart checkboxes change, update total in Buy Now page
        $('.item-checkbox').change(function() {
            updateTotal();
        });

        // Make sure total updates on page load in case items are pre-checked
        updateTotal();
    });
</script>
@endpush