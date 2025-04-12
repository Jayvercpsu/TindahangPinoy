<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Account</title>

    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/account.css') }}" rel="stylesheet">

</head>

<body>

    <div class="container-fluid">
        <div class="row">

            @include('my-account.includes.sidebar')

            <!-- Orders Table -->
            <div class="col-lg-9">
                <div class="main-container">
                    <div class="d-flex justify-content-end pb-3">
                        <form method="GET" action="{{ route('account.index') }}" class="d-flex align-items-center">
                            <label class="text-muted me-2 fw-bold" for="order-sort">Sort Orders:</label>
                            <select class="form-select w-auto border-primary shadow-sm" id="order-sort" name="status" onchange="this.form.submit()">
                                <option value="">All</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in progress" {{ request('status') == 'in progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>Canceled</option>
                            </select>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>Order #</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Date Purchased</th>
                                    <th>Payment Method</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr>
                                    <td><a href="#" class="text-decoration-none">{{ $order->order_no }}</a></td>
                                    <td>
                                        <span>{{ $order->product->name }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $order->quantity }}</span>
                                    </td>
                                    <td>
                                        <span>₱{{ number_format($order->product->price, 2) }}</span>
                                    </td>
                                    <td>{{ $order->created_at->format('F j, Y') }}</td>
                                    <td>{{ $order->payment_method }}</td>
                                    <td>
                                        @if($order->status == 'approved')
                                        <span class="badge bg-success">Approved</span>
                                        @elseif($order->status == 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($order->status == 'in progress')
                                        <span class="badge bg-info">In Progress</span>
                                        @elseif($order->status == 'delivered')
                                        <span class="badge bg-primary">Delivered</span>
                                        @elseif($order->status == 'rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                        @else
                                        <span class="badge bg-secondary">Canceled</span>
                                        @endif
                                    </td>
                                    <td>₱{{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7">No orders found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        <nav>
                            <ul class="pagination pagination-lg shadow-sm">
                                {{ $orders->links('pagination::bootstrap-4') }}
                            </ul>
                        </nav>
                    </div>
                </div> <!-- End Main Container -->
            </div> <!-- End Orders Table -->


        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>