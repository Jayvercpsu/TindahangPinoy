<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Chart.js for Data Visualization -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title>Tindahang Pinoy</title>
</head>

<body>

    @include('admin.includes.sidebar')


    <!-- NAVBAR -->
    <section id="content">

        @include('admin.includes.navbar')

        <div class="container mt-4">
            <!-- Title & Breadcrumb -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="h3">Dashboard</h1>

                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>

            </div>

            <!-- Info Cards -->
            <div class="row">
                <!-- Total Sales -->
                <div class="col-md-6">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h2 class="card-title">234</h2>
                            <p class="card-text">Total Sales</p>
                            <i class="fa fa-shopping-cart fa-2x"></i>
                        </div>
                    </div>
                </div>

                <!-- Stock Levels -->
                <div class="col-md-6">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-body">
                            <h2 class="card-title">1023</h2>
                            <p class="card-text">Stock Levels</p>
                            <i class="fa fa-boxes fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Visualization Section -->
            <div class="row">
                <!-- Sales Report -->
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">Sales Report</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- NAVBAR -->
    <!-- MAIN -->


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
</body>

</html>