@extends('layouts.layout')

@push('styles')
<!-- Include DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')
<div class="container">
    <h2 class="my-4">Your Cart</h2>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if($cart->isEmpty())
    <div class="alert alert-warning text-center">
        <strong>Your cart is empty.</strong>
    </div>
    @else
    <div class="table-responsive">
        <table id="cartTable" class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Stock</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php $grandTotal = 0; @endphp
                @foreach($cart as $item)
                @php 
                    $totalPrice = $item->quantity * $item->product->price; 
                    $grandTotal += $totalPrice;
                @endphp
                <tr>
                    <td>
                        <img src="{{ asset('storage/' . $item->product->image) }}" class="img-thumbnail" width="50">
                    </td>
                    <td>{{ $item->product->name }}</td>
                    <td><strong class="{{ $item->product->stock > 0 ? 'text-success' : 'text-danger' }}">{{ $item->product->stock }}</strong></td>
                    <td>₱{{ number_format($item->product->price, 2) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td><strong>₱{{ number_format($totalPrice, 2) }}</strong></td>
                    <td>
                        <!-- 🛑 Trigger the Modal -->
                        <button class="btn btn-danger btn-sm delete-btn" 
                            data-id="{{ $item->id }}" 
                            data-name="{{ $item->product->name }}" 
                            data-bs-toggle="modal" 
                            data-bs-target="#deleteConfirmModal">
                            <i class="bi bi-trash"></i> Remove
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="table-dark">
                <tr>
                    <td colspan="5" class="text-end"><strong>Grand Total:</strong></td>
                    <td><strong>₱{{ number_format($grandTotal, 2) }}</strong></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <a href="{{ route('cart.clear') }}" class="btn btn-warning">
        <i class="bi bi-x-circle"></i> Clear Cart
    </a>
    @endif
</div>

<!-- 🔴 Include Delete Modal Component -->
@include('components.modal')

@endsection

@push('scripts')
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- Initialize DataTable -->
<script>
    $(document).ready(function () {
        $('#cartTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthMenu": [5, 10, 25, 50],
            "language": {
                "search": "Search Cart:",
                "lengthMenu": "Show _MENU_ items per page"
            }
        });

        // Handle delete button click
        $('.delete-btn').click(function () {
            let itemId = $(this).data('id');
            let productName = $(this).data('name');

            // Update modal content
            $('#productName').text(productName);
            $('#confirmDeleteBtn').attr('href', '{{ route("cart.remove", ":id") }}'.replace(':id', itemId));
        });
    });
</script>

@endpush
