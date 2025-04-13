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
                        <label class="text-muted me-2" for="order-sort">Sort Orders</label>
                        <select class="form-select w-auto" id="order-sort">
                            <option>All</option>
                            <option value="approved">Approved</option>
                            <option value="pending">Pending</option>
                            <option value="in progress">In Progress</option>
                            <option value="delivered">Delivered</option>
                            <option value="rejected">Rejected</option>
                            <option value="canceled">Canceled</option>
                        </select>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>Order #</th>
                                    <th>Date Purchased</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td><a href="#" class="text-decoration-none">{{ $order->order_no }}</a></td>
                                    <td>{{ $order->created_at->format('F j, Y') }}</td>
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> <!-- End Main Container -->
            </div> <!-- End Orders Table -->


        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>