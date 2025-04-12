<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process Refunds</title>
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
                <h1 class="h3">Process Refunds</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">Manage Transactions</li>
                    <li class="breadcrumb-item active">Process Refunds</li>
                </ol>
            </div>

            @if(session('success'))
            <div id="successMessage" class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div id="errorMessage" class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif

            <!-- Refund Stats -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Refunds</h5>
                            <h2 class="mb-0">$1,245.75</h2>
                            <small>Current month</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-dark">
                        <div class="card-body">
                            <h5 class="card-title">Pending Refunds</h5>
                            <h2 class="mb-0">3</h2>
                            <small>Awaiting processing</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title">Processed Refunds</h5>
                            <h2 class="mb-0">12</h2>
                            <small>Current month</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <h5 class="card-title">Refund Rate</h5>
                            <h2 class="mb-0">2.4%</h2>
                            <small>of total orders</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Refunds Table -->
            <div class="card mb-4">
                <div class="card-header bg-warning text-dark">
                    <h3 class="card-title">Pending Refund Requests</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="pendingRefundsTable" class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Refund ID</th>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Date Requested</th>
                                    <th>Amount</th>
                                    <th>Reason</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Example data, you would replace this with your actual data -->
                                <tr>
                                    <td>REF-001</td>
                                    <td>ORD-015</td>
                                    <td>Alice Johnson</td>
                                    <td>2025-04-10</td>
                                    <td>$85.99</td>
                                    <td>Item damaged</td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewRefundModal" onclick="viewRefund('REF-001')">
                                                <i class="fa fa-eye"></i> View
                                            </button>
                                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#approveRefundModal" onclick="approveRefund('REF-001')">
                                                <i class="fa fa-check"></i> Approve
                                            </button>
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#denyRefundModal" onclick="denyRefund('REF-001')">
                                                <i class="fa fa-times"></i> Deny
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>REF-002</td>
                                    <td>ORD-017</td>
                                    <td>Thomas Wilson</td>
                                    <td>2025-04-09</td>
                                    <td>$129.50</td>
                                    <td>Wrong item received</td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewRefundModal" onclick="viewRefund('REF-002')">
                                                <i class="fa fa-eye"></i> View
                                            </button>
                                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#approveRefundModal" onclick="approveRefund('REF-002')">
                                                <i class="fa fa-check"></i> Approve
                                            </button>
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#denyRefundModal" onclick="denyRefund('REF-002')">
                                                <i class="fa fa-times"></i> Deny
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>REF-003</td>
                                    <td>ORD-019</td>
                                    <td>Emily Parker</td>
                                    <td>2025-04-08</td>
                                    <td>$45.75</td>
                                    <td>Changed mind</td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewRefundModal" onclick="viewRefund('REF-003')">
                                                <i class="fa fa-eye"></i> View
                                            </button>
                                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#approveRefundModal" onclick="approveRefund('REF-003')">
                                                <i class="fa fa-check"></i> Approve
                                            </button>
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#denyRefundModal" onclick="denyRefund('REF-003')">
                                                <i class="fa fa-times"></i> Deny
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Recent Processed Refunds -->
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3 class="card-title">Recent Processed Refunds</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="processedRefundsTable" class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Refund ID</th>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Date Requested</th>
                                    <th>Date Processed</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Example data, you would replace this with your actual data -->
                                <tr>
                                    <td>REF-000</td>
                                    <td>ORD-010</td>
                                    <td>David Miller</td>
                                    <td>2025-04-05</td>
                                    <td>2025-04-06</td>
                                    <td>$99.99</td>
                                    <td><span class="badge bg-success">Approved</span></td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewRefundModal" onclick="viewRefund('REF-000')">
                                            <i class="fa fa-eye">                                            </i> View
                                        </button>
                                    </td>
                                </tr>
                                <!-- More processed refunds here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- View Refund Modal -->
    <div class="modal fade" id="viewRefundModal" tabindex="-1" aria-labelledby="viewRefundModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Refund Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="refundDetails">
                    <!-- Dynamic content via JS -->
                </div>
            </div>
        </div>
    </div>

    <!-- Approve Refund Modal -->
    <div class="modal fade" id="approveRefundModal" tabindex="-1" aria-labelledby="approveRefundModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="approveRefundForm" method="POST" action="">
                @csrf
                <input type="hidden" name="refund_id" id="approveRefundId">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">Approve Refund</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to approve this refund?
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Approve</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Deny Refund Modal -->
    <div class="modal fade" id="denyRefundModal" tabindex="-1" aria-labelledby="denyRefundModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="denyRefundForm" method="POST" action="">
                @csrf
                <input type="hidden" name="refund_id" id="denyRefundId">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">Deny Refund</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to deny this refund?
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Deny</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#pendingRefundsTable').DataTable();
            $('#processedRefundsTable').DataTable();
        });

        function viewRefund(refundId) {
            $('#refundDetails').html('<p>Loading refund details for ' + refundId + '...</p>');
            // Example AJAX (replace with real route)
            // $.get('/admin/refunds/' + refundId, function(data) {
            //     $('#refundDetails').html(data);
            // });
        }

        function approveRefund(refundId) {
            $('#approveRefundId').val(refundId);
        }

        function denyRefund(refundId) {
            $('#denyRefundId').val(refundId);
        }
    </script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>
