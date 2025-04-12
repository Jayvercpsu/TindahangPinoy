<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completed Orders</title>
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
                <h1 class="h3">Completed Orders</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">Manage Orders</li>
                    <li class="breadcrumb-item active">Completed Orders</li>
                </ol>
            </div>

            @if(session('success'))
            <div id="successMessage" class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <!-- Completed Orders Table -->
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3 class="card-title">Completed Orders</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="completedOrdersTable" class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Order Date</th>
                                    <th>Completion Date</th>
                                    <th>Total</th>
                                    <th>Payment Method</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Example data, you would replace this with your actual data -->
                                <tr>
                                    <td>1</td>
                                    <td>ORD-002</td>
                                    <td>Jane Smith</td>
                                    <td>2025-04-09</td>
                                    <td>2025-04-10</td>
                                    <td>$89.50</td>
                                    <td>Credit Card</td>
                                    <td>
                                        <a href="#" class="btn btn-primary btn-sm">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                        <a href="#" class="btn btn-secondary btn-sm">
                                            <i class="fa fa-file-pdf"></i> Invoice
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>ORD-004</td>
                                    <td>Michael Brown</td>
                                    <td>2025-04-07</td>
                                    <td>2025-04-09</td>
                                    <td>$120.75</td>
                                    <td>PayPal</td>
                                    <td>
                                        <a href="#" class="btn btn-primary btn-sm">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                        <a href="#" class="btn btn-secondary btn-sm">
                                            <i class="fa fa-file-pdf"></i> Invoice
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>ORD-006</td>
                                    <td>Sarah Davis</td>
                                    <td>2025-04-05</td>
                                    <td>2025-04-06</td>
                                    <td>$199.99</td>
                                    <td>Bank Transfer</td>
                                    <td>
                                        <a href="#" class="btn btn-primary btn-sm">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                        <a href="#" class="btn btn-secondary btn-sm">
                                            <i class="fa fa-file-pdf"></i> Invoice
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Monthly Orders Chart -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Completed Orders - Monthly Statistics</h3>
                </div>
                <div class="card-body">
                    <div id="completedOrdersChart" style="height: 300px;"></div>
                </div>
            </div>

        </div>
    </section>

    <!-- Include jQuery & DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- Initialize DataTable -->
    <script>
        $(document).ready(function() {
            $('#completedOrdersTable').DataTable({
                "paging": true, // Enable pagination
                "searching": true, // Enable search filter
                "ordering": true, // Enable column sorting
                "info": true, // Show table info
                "lengthMenu": [5, 10, 25, 50], // Define page length options
            });
        });

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

    <!-- ApexCharts JS -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    
    <!-- Chart Initialization -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var options = {
                series: [{
                    name: 'Completed Orders',
                    data: [31, 40, 35, 51, 49, 62, 69, 91, 80, 85, 90, 103]
                }],
                chart: {
                    height: 300,
                    type: 'line',
                    zoom: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'straight'
                },
                grid: {
                    row: {
                        colors: ['#f3f3f3', 'transparent'],
                        opacity: 0.5
                    },
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                },
                colors: ['#198754'] // Match success green color
            };

            var chart = new ApexCharts(document.querySelector("#completedOrdersChart"), options);
            chart.render();
        });
    </script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
</body>

</html>