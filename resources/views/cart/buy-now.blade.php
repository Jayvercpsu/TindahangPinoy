@extends('layouts.layout')

@push('styles')
<!-- Include DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<style>
    /* 🔹 Red arrow animation to highlight missing address */
    @keyframes arrow-bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }
    
    .highlight {
        border: 2px solid red;
        animation: arrow-bounce 1s infinite;
    }

    .arrow {
        display: inline-block;
        font-size: 20px;
        color: red;
        animation: arrow-bounce 1s infinite;
    }

    /* 🔹 Center align payment section */
    .payment-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        margin-top: 30px;
        margin-bottom: 30px;
    }

    /* 🔹 Add spacing between sections */
    .section-spacing {
        margin-top: 20px;
        margin-bottom: 20px;
    }
</style>
@endpush

@section('content')
<div class="container">
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

    <div class="row">
        <!-- 📍 Shipping Address -->
        <div class="col-md-6 section-spacing">
            <h4>📍 Shipping Address</h4>
            @if($address)
                <p><strong>Address:</strong> {{ $address->address }}</p>
                <p><strong>City:</strong> {{ $address->city }}</p>
                <p><strong>State:</strong> {{ $address->state }}</p>
                <p><strong>Zip Code:</strong> {{ $address->zip_code }}</p>
                <a href="{{ route('account.addresses') }}" class="btn btn-primary btn-sm">Edit Address</a>
            @else
                <div class="alert alert-warning">
                    <strong>⚠ Please fill in your address first.</strong>
                    <span class="arrow">⬇</span>
                </div>
                <a href="{{ route('account.addresses') }}" class="btn btn-danger">Fill Address</a>
            @endif
        </div>

        <!-- 💳 Payment Section -->
        <div class="col-md-6 section-spacing">
            <div class="payment-section">
                <h4>💳 Payment Method</h4>
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
                    <br>
                    <button type="submit" class="btn btn-success w-100">Confirm Order</button>
                </form>
            </div>
        </div>
    </div>

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
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
