<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Sales Analytics</title>
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
                <h1 class="h3">View Sales Analytics</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Sales Analytics</li>
                </ol>
            </div>

            <!-- Month and Total Sales Display -->
            <div class="alert alert-info">
                <strong>Sales Analytics for April 2025</strong><br>
                Total Sales: <strong>5000</strong>
            </div>

            @if(session('success'))
            <div id="successMessage" class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <!-- Analytics Table -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Top Selling Products</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="analyticsTable" class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Total Sold</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Static data (UI-only) -->
                                <tr>
                                    <td>1</td>
                                    <td><a href="{{ url('/admin/products/1') }}">Product A</a></td>
                                    <td>120</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td><a href="{{ url('/admin/products/2') }}">Product B</a></td>
                                    <td>80</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td><a href="{{ url('/admin/products/3') }}">Product C</a></td>
                                    <td>50</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td><a href="{{ url('/admin/products/4') }}">Product D</a></td>
                                    <td>150</td>
                                </tr>
                                <!-- End of sample static data -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- JavaScript to Set Form Action -->
    <script>
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
            $('#analyticsTable').DataTable({
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
