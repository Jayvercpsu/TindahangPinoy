<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>
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
                <h1 class="h3">View Orders</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">Manage Orders</li>
                    <li class="breadcrumb-item active">View Orders</li>
                </ol>
            </div>

            @if(session('success'))
            <div id="successMessage" class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif


            <!-- Orders Table -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">All Orders</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="ordersTable" class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Order Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
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
                                    <td><span class="badge bg-warning">Pending</span></td>
                                    <td>
                                        <a href="#" class="btn btn-primary btn-sm">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteOrderModal"
                                            onclick="setDeleteOrder('ORD-001')">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>ORD-002</td>
                                    <td>Jane Smith</td>
                                    <td>2025-04-09</td>
                                    <td>$89.50</td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                    <td>
                                        <a href="#" class="btn btn-primary btn-sm">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteOrderModal"
                                            onclick="setDeleteOrder('ORD-002')">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>ORD-003</td>
                                    <td>Robert Johnson</td>
                                    <td>2025-04-08</td>
                                    <td>$229.99</td>
                                    <td><span class="badge bg-warning">Pending</span></td>
                                    <td>
                                        <a href="#" class="btn btn-primary btn-sm">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteOrderModal"
                                            onclick="setDeleteOrder('ORD-003')">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteOrderModal" tabindex="-1" aria-labelledby="deleteOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteOrderModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this order? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteOrderForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript to Set Form Action -->
    <script>
        function setDeleteOrder(orderId) {
            document.getElementById('deleteOrderForm').action = "/admin/orders/" + orderId;
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
            $('#ordersTable').DataTable({
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