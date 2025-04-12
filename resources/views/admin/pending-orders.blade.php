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
                    <div class="card bg-info text-dark">
                        <div class="card-body">
                            <h5 class="card-title">Ready to Ship</h5>
                            <h2 class="mb-0">2</h2>
                            <small>Packaged orders</small>
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
                                <!-- Example data, you would replace this with your actual data -->
                                <tr>
                                    <td>1</td>
                                    <td>ORD-001</td>
                                    <td>John Doe</td>
                                    <td>2025-04-10</td>
                                    <td>$159.99</td>
                                    <td><span class="badge bg-warning text-dark">New</span></td>
                                    <td>2 days</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-primary btn-sm">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#approveOrderModal"
                                                onclick="setApproveOrder('ORD-001')">
                                                <i class="fa fa-check-circle"></i> Approve
                                            </button>
                                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#completeOrderModal"
                                                onclick="setCompleteOrder('ORD-001')">
                                                <i class="fa fa-check"></i> Complete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>ORD-003</td>
                                    <td>Robert Johnson</td>
                                    <td>2025-04-08</td>
                                    <td>$229.99</td>
                                    <td><span class="badge bg-primary">Approved</span></td>
                                    <td>4 days</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-primary btn-sm">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#completeOrderModal"
                                                onclick="setCompleteOrder('ORD-003')">
                                                <i class="fa fa-check"></i> Complete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>ORD-005</td>
                                    <td>Emily Wilson</td>
                                    <td>2025-04-11</td>
                                    <td>$75.50</td>
                                    <td><span class="badge bg-warning text-dark">New</span></td>
                                    <td>1 day</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-primary btn-sm">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#approveOrderModal"
                                                onclick="setApproveOrder('ORD-005')">
                                                <i class="fa fa-check-circle"></i> Approve
                                            </button>
                                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#completeOrderModal"
                                                onclick="setCompleteOrder('ORD-005')">
                                                <i class="fa fa-check"></i> Complete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
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
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fa fa-check-circle text-success me-2"></i>
                                Order #ORD-012 was approved by Admin
                            </div>
                            <span class="text-muted small">10 minutes ago</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fa fa-truck text-primary me-2"></i>
                                Order #ORD-008 was marked as shipped
                            </div>
                            <span class="text-muted small">1 hour ago</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fa fa-plus-circle text-warning me-2"></i>
                                New order #ORD-015 received
                            </div>
                            <span class="text-muted small">2 hours ago</span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </section>

    <!-- Approve Order Modal -->
    <div class="modal fade" id="approveOrderModal" tabindex="-1" aria-labelledby="approveOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="approveOrderModalLabel">Approve Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to approve this order? This will move it to the processing stage.</p>
                    <form id="approveOrderForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="approveNotes" class="form-label">Notes (Optional)</label>
                            <textarea class="form-control" id="approveNotes" name="notes" rows="3" placeholder="Add any special handling instructions..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="approveOrderForm" class="btn btn-info">Approve Order</button>
                </div>
            </div>
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

    <!-- JavaScript to Set Form Action -->
    <script>
        function setApproveOrder(orderId) {
            document.getElementById('approveOrderForm').action = "/admin/orders/" + orderId + "/approve";
        }

        function setCompleteOrder(orderId) {
            document.getElementById('completeOrderForm').action = "/admin/orders/" + orderId + "/complete";
        }

        document.addEventListener("DOMContentLoaded", function() {
            let alertBox = document.getElementById("successMessage");

            if (alertBox) {
                setTimeout(function() {
                    alertBox.style.transition = "opacity 1s ease-out";
                    alertBox.style.opacity = "0";
                    setTimeout(() => alertBox.remove(), 1000); // Remove from DOM after fade out
                }, 2000); // Show for 2 seconds before fading
            }
        });
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