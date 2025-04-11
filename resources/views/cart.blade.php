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
                    <th>
                        <input type="checkbox" id="selectAll">
                    </th>
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
                        <input type="checkbox" class="item-checkbox" data-price="{{ $totalPrice }}">
                    </td>
                    <td>
                        <img src="{{ asset('storage/' . $item->product->image) }}" class="img-thumbnail" width="50">
                    </td>
                    <td>{{ $item->product->name }}</td>
                    <td><strong class="{{ $item->product->stock > 0 ? 'text-success' : 'text-danger' }}">{{ $item->product->stock }}</strong></td>
                    <td>₱{{ number_format($item->product->price, 2) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td><strong>₱{{ number_format($totalPrice, 2) }}</strong></td>
                    <td>
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
                    <td></td>
                    <td colspan="5" class="text-end"><strong id="grandTotalText">Grand Total:</strong></td>
                    <td><strong id="grandTotalAmount">₱{{ number_format($grandTotal, 2) }}</strong></td>
                    <!-- Cart Page -->
                    <td>
                        <form id="buyNowForm" action="{{ route('cart.buy-now') }}" method="GET">
                            <input type="hidden" name="selected_items" id="selectedItemsInput">
                            <button type="submit" id="buyNowBtn" class="btn btn-danger d-none">
                                <i class="bi bi-cart-check"></i> Buy Now
                            </button>
                        </form>
                    </td>
                </tr>
            </tfoot>

        </table>
    </div>

    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#clearCartConfirmModal">
        <i class="bi bi-x-circle"></i> Clear Cart
    </button>

    @endif
</div>

<!-- Clear Cart Confirmation Modal -->
<div class="modal fade" id="clearCartConfirmModal" tabindex="-1" aria-labelledby="clearCartLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clearCartLabel">Confirm Clear Cart</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to clear your cart? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="{{ route('cart.clear') }}" class="btn btn-danger">Yes, Clear Cart</a>
            </div>
        </div>
    </div>
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
    $(document).ready(function() {
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
        $('.delete-btn').click(function() {
            let itemId = $(this).data('id');
            let productName = $(this).data('name');

            // Update modal content
            $('#productName').text(productName);
            $('#confirmDeleteBtn').attr('href', '{{ route("cart.remove", ":id") }}'.replace(':id', itemId));
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#selectAll').change(function() {
            $('.item-checkbox').prop('checked', $(this).prop('checked'));
            updateTotal();
        });

        $('.item-checkbox').change(function() {
            updateTotal();
        });

        function updateTotal() {
            let total = 0;
            let anyChecked = false;
            let selectedItems = [];

            $('.item-checkbox:checked').each(function() {
                total += parseFloat($(this).data('price'));
                selectedItems.push($(this).data('id'));
                anyChecked = true;
            });

            $('#grandTotalAmount').text('₱' + total.toFixed(2));
            $('#selectedItemsInput').val(selectedItems.join(',')); // Store selected items

            if (anyChecked) {
                $('#grandTotalText').text('Buy Now:');
                $('#buyNowBtn').removeClass('d-none');
            } else {
                $('#grandTotalText').text('Grand Total:');
                $('#buyNowBtn').addClass('d-none');
            }
        }
    });
</script>


@endpush