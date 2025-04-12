<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Sales</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- Include DateRangePicker CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
                <h1 class="h3">View Sales</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">Manage Transactions</li>
                    <li class="breadcrumb-item active">View Sales</li>
                </ol>
            </div>

            @if(session('success'))
            <div id="successMessage" class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <!-- Sales Summary -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Sales</h5>
                            <h2 class="mb-0">$9,875.50</h2>
                            <small>Current month</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title">Orders</h5>
                            <h2 class="mb-0">124</h2>
                            <small>Current month</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h5 class="card-title">Average Order</h5>
                            <h2 class="mb-0">$79.64</h2>
                            <small>Current month</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-dark">
                        <div class="card-body">
                            <h5 class="card-title">Revenue Growth</h5>
                            <h2 class="mb-0">+12.5%</h2>
                            <small>vs last month</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sales Filter -->
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Filter Sales</h3>
                </div>
                <div class="card-body">
                    <form id="salesFilterForm" class="row g-3">
                        <div class="col-md-4">
                            <label for="dateRange" class="form-label">Date Range</label>
                            <input type="text" class="form-control" id="dateRange" name="dateRange" value="04/01/2025 - 04/12/2025">
                        </div>
                        <div class="col-md-3">
                            <label for="paymentMethod" class="form-label">Payment Method</label>
                            <select class="form-select" id="paymentMethod" name="paymentMethod">
                                <option value="">All Methods</option>
                                <option value="credit_card">Credit Card</option>
                                <option value="paypal">PayPal</option>
                                <option value="bank_transfer">Bank Transfer</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">All Statuses</option>
                                <option value="completed">Completed</option>
                                <option value="pending">Pending</option>
                                <option value="refunded">Refunded</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sales Chart -->
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Sales Trend</h3>
                </div>
                <div class="card-body">
                    <div id="salesChart" style="height: 300px;"></div>
                </div>
            </div>

            <!-- Sales Table -->
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Sales Transactions</h3>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-download me-1"></i> Export
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                                <li><a class="dropdown-item" href="#"><i class="fa fa-file-excel me-2"></i>Export to Excel</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fa fa-file-pdf me-2"></i>Export to PDF</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fa fa-file-csv me-2"></i>Export to CSV</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="salesTable" class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Transaction ID</th>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Payment Method</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Example data, you would replace this with your actual data -->
                                <tr>
                                    <td>TRX-001245</td>
                                    <td>ORD-002</td>
                                    <td>Jane Smith</td>
                                    <td>2025-04-10</td>
                                    <td>Credit Card</td>
                                    <td>$89.50</td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-primary btn-sm">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                            <a href="#" class="btn btn-secondary btn-sm">
                                                <i class="fa fa-file-invoice"></i> Invoice
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>TRX-001244</td>
                                    <td>ORD-001</td>
                                    <td>John Doe</td>
                                    <td>2025-04-09</td>
                                    <td>PayPal</td>
                                    <td>$159.99</td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-primary btn-sm">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                            <a href="#" class="btn btn-secondary btn-sm">
                                                <i class="fa fa-file-invoice"></i> Invoice
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>TRX-001243</td>
                                    <td>ORD-003</td>
                                    <td>Robert Johnson</td>
                                    <td>2025-04-08</td>
                                    <td>Bank Transfer</td>
                                    <td>$229.99</td>
                                    <td><span class="badge bg-warning text-dark">Pending</span></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-primary btn-sm">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                            <a href="#" class="btn btn-secondary btn-sm disabled">
                                                <i class="fa fa-file-invoice"></i> Invoice
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>TRX-001242</td>
                                    <td>ORD-006</td>
                                    <td>Sarah Davis</td>
                                    <td>2025-04-07</td>
                                    <td>Credit Card</td>
                                    <td>$199.99</td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-primary btn-sm">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                            <a href="#" class="btn btn-secondary btn-sm">
                                                <i class="fa fa-file-invoice"></i> Invoice
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>TRX-001241</td>
                                    <td>ORD-004</td>
                                    <td>Michael Brown</td>
                                    <td>2025-04-06</td>
                                    <td>PayPal</td>
                                    <td>$120.75</td>
                                    <td><span class="badge bg-danger">Refunded</span></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-primary btn-sm">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                            <a href="#" class="btn btn-secondary btn-sm">
                                                <i class="fa fa-file-invoice"></i> Invoice
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Payment Method Distribution -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Payment Method Distribution</h3>
                        </div>
                        <div class="card-body">
                            <div id="paymentMethodChart" style="height: 300px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Top Customers</h3>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>John Doe</strong>
                                        <div class="text-muted small">12 purchases</div>
                                    </div>
                                    <span class="badge bg-primary rounded-pill">$1,245.50</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Sarah Davis</strong>
                                        <div class="text-muted small">8 purchases</div>
                                    </div>
                                    <span class="badge bg-primary rounded-pill">$980.75</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Michael Brown</strong>
                                        <div class="text-muted small">6 purchases</div>
                                    </div>
                                    <span class="badge bg-primary rounded-pill">$765.25</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Robert Johnson</strong>
                                        <div class="text-muted small">5 purchases</div>
                                    </div>
                                    <span class="badge bg-primary rounded-pill">$620.50</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Jane Smith</strong>
                                        <div class="text-muted small">4 purchases</div>
                                    </div>
                                    <span class="badge bg-primary rounded-pill">$512.30</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Include jQuery & DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- Include DateRangePicker Dependencies -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <!-- ApexCharts JS -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- Initialize DataTable & DateRangePicker -->
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#salesTable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "lengthMenu": [5, 10, 25, 50],
                "order": [[3, "desc"]] // Sort by date column (index 3) in descending order
            });

            // Initialize DateRangePicker
            $('#dateRange').daterangepicker({
                startDate: moment().subtract(30, 'days'),
                endDate: moment(),
                ranges: {
                   'Today': [moment(), moment()],
                   'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                   'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                   'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                   'This Month': [moment().startOf('month'), moment().endOf('month')],
                   'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            });

            // Handle success message fade out
            let alertBox = document.getElementById("successMessage");
            if (alertBox) {
                setTimeout(function() {
                    alertBox.style.transition = "opacity 1s ease-out";
                    alertBox.style.opacity = "0";
                    setTimeout(() => alertBox.remove(), 1000);
                }, 2000);
            }
        });

        // Sales Chart
        document.addEventListener("DOMContentLoaded", function() {
            var salesChartOptions = {
                series: [{
                    name: 'Sales',
                    data: [31000, 40000, 35000, 51000, 49000, 62000, 69000, 91000, 80000, 85000, 90000, 103000]
                }],
                chart: {
                    height: 300,
                    type: 'area',
                    toolbar: {
                        show: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return "$" + val.toLocaleString();
                        }
                    }
                },
                colors: ['#0d6efd']
            };

            var salesChart = new ApexCharts(document.querySelector("#salesChart"), salesChartOptions);
            salesChart.render();

            // Payment Method Chart
            var paymentMethodOptions = {
                series: [65, 25, 10],
                chart: {
                    width: '100%',
                    type: 'pie',
                },
                labels: ['Credit Card', 'PayPal', 'Bank Transfer'],
                colors: ['#0d6efd', '#198754', '#6c757d'],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            var paymentMethodChart = new ApexCharts(document.querySelector("#paymentMethodChart"), paymentMethodOptions);
            paymentMethodChart.render();
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
</body>

</html>