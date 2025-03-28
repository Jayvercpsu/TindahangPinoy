@extends('layouts.layout')

@section('content')
<div class="container">
    <h2>Your Cart</h2>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if($cart->isEmpty())
    <p>Your cart is empty.</p>
    @else
    <table class="table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cart as $item)
            <tr>
                <td>
                    <img src="{{ asset('storage/' . $item->product->image) }}" width="50">
                </td>
                <td>{{ $item->product->name }}</td>
                <td>₱{{ number_format($item->product->price, 2) }}</td>
                <td>{{ $item->quantity }}</td>
                <td>
                    <a href="{{ route('cart.remove', $item->id) }}" class="btn btn-danger btn-sm">
                        Remove
                    </a>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('cart.clear') }}" class="btn btn-warning">
        Clear Cart
    </a>

    @endif
</div>
@endsection