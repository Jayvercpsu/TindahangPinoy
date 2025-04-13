<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Orders</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

    @include('admin.includes.sidebar')

    <!-- NAVBAR -->
    <section id="content">
        @include('admin.includes.navbar')

        <div class="container mt-4">
            <!-- Title & Breadcrumb -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="h3">Pending Orders</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">Manage Orders</li>
                    <li class="breadcrumb-item active">Pending Orders</li>
                </ol>
            </div>

            @if(session('success'))
            <div id="successMessage" class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <!-- Order Status Summary -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-warning text-dark">
                        <div class="card-body">
                            <h5 class="card-title">New Orders</h5>
                            <h2 class="mb-0">3</h2>
                            <small>Awaiting approval</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title">Approved Orders</h5>
                            <h2 class="mb-0">5</h2>
                            <small>Processing</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title">Shipped</h5>
                            <h2 class="mb-0">1</h2>
                            <small>In transit</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Orders Table -->
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h3 class="card-title">Pending Orders</h3>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="pendingOrdersTable" class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Order Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Waiting Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $index => $order)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $order->order_no }}</td>
                                    <td>{{ $order->user->name ?? 'Unknown' }}</td>
                                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                    <td>₱{{ number_format($order->total_amount, 2) }}</td>
                                    <td>
                                        @php
                                        $badgeClass = match($order->status) {
                                        'approved' => 'bg-primary',
                                        'pending' => 'bg-warning text-white',
                                        'inprogress' => 'bg-info',
                                        'delivered' => 'bg-success',
                                        'rejected', 'canceled' => 'bg-danger',
                                        default => 'bg-secondary'
                                        };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ ucfirst($order->status) }}</span>
                                    </td>
                                    <td>
                                        {{ $order->created_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-primary btn-sm">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                            @if($order->status == 'pending')
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#approveOrderModal"
                                                onclick="setApproveOrder('{{ $order->order_no }}')">
                                                <i class="fa fa-check-circle"></i> Approve
                                            </button>
                                            @endif
                                            @if(in_array($order->status, ['approved', 'inprogress']))
                                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#completeOrderModal"
                                                onclick="setCompleteOrder('{{ $order->order_no }}')">
                                                <i class="fa fa-check"></i> Complete
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

            <!-- Recent Order Activity -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Recent Order Activity</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @forelse($recentOrders as $order)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                @php
                                $icon = match($order->status) {
                                'approved' => 'fa-check-circle text-success',
                                'pending' => 'fa-hourglass-half text-warning',
                                'inprogress' => 'fa-cogs text-info',
                                'delivered' => 'fa-truck text-primary',
                                'rejected' => 'fa-times-circle text-danger',
                                'canceled' => 'fa-ban text-danger',
                                default => 'fa-info-circle text-muted'
                                };
                                @endphp
                                <i class="fa {{ $icon }} me-2"></i>
                                Order #{{ $order->order_no }} was {{ $order->status }}
                                @if($order->user)
                                by {{ $order->user->name }}
                                @endif
                            </div>
                            <span class="text-muted small">{{ $order->updated_at->diffForHumans() }}</span>
                        </li>
                        @empty
                        <li class="list-group-item">
                            <i class="fa fa-info-circle text-muted me-2"></i>
                            No recent order activity found.
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>




        </div>
    </section>

    <!-- Approve Order Modal -->
    <div class="modal fade" id="approveOrderModal" tabindex="-1" aria-labelledby="approveOrderLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.update-order-status') }}">
                @csrf
                <input type="hidden" name="order_no" id="approveOrderInput">
                <input type="hidden" name="status" value="approved">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="approveOrderLabel">Approve Order</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to approve this order?
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">Yes, Approve</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- Complete Order Modal -->
    <div class="modal fade" id="completeOrderModal" tabindex="-1" aria-labelledby="completeOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="completeOrderModalLabel">Mark as Complete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to mark this order as complete?</p>
                    <form id="completeOrderForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="trackingNumber" class="form-label">Tracking Number (Optional)</label>
                            <input type="text" class="form-control" id="trackingNumber" name="tracking_number" placeholder="Enter shipping tracking number...">
                        </div>
                        <div class="mb-3">
                            <label for="completionNotes" class="form-label">Notes (Optional)</label>
                            <textarea class="form-control" id="completionNotes" name="completion_notes" rows="3" placeholder="Add any completion notes..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="completeOrderForm" class="btn btn-success">Complete Order</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setApproveOrder(orderNo) {
            document.getElementById('approveOrderInput').value = orderNo;
        }
    </script>


    <!-- Include jQuery & DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- Initialize DataTable -->
    <script>
        $(document).ready(function() {
            $('#pendingOrdersTable').DataTable({
                "paging": true, // Enable pagination
                "searching": true, // Enable search filter
                "ordering": true, // Enable column sorting
                "info": true, // Show table info
                "lengthMenu": [5, 10, 25, 50], // Define page length options
            });
        });
    </script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
</body>

</html>