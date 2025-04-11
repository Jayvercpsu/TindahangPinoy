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
                <!-- Total Users -->
                <div class="col-md-3">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <h2 class="card-title">{{ \App\Models\User::count() }}</h2>
                            <p class="card-text">Total Users</p>
                            <i class="fa fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Total Products -->
                <div class="col-md-3">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-body">
                            <h2 class="card-title">{{ \App\Models\Product::count() }}</h2>
                            <p class="card-text">Total Products</p>
                            <i class="fa fa-box fa-2x"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Total Sales -->
                <div class="col-md-3">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h2 class="card-title">234</h2>
                            <p class="card-text">Total Sales</p>
                            <i class="fa fa-shopping-cart fa-2x"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Stock Levels -->
                <div class="col-md-3">
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
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">Sales Report</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>
                </div>
                
                <!-- User Growth -->
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">User Statistics</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="userChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Activities Section -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Recent Activities</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Activity</th>
                                            <th>User</th>
                                            <th>Time</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>New order placed</td>
                                            <td>John Doe</td>
                                            <td>2 hours ago</td>
                                            <td><span class="badge bg-success">Completed</span></td>
                                        </tr>
                                        <tr>
                                            <td>New product added</td>
                                            <td>Admin</td>
                                            <td>3 hours ago</td>
                                            <td><span class="badge bg-primary">Active</span></td>
                                        </tr>
                                        <tr>
                                            <td>User registration</td>
                                            <td>Maria Garcia</td>
                                            <td>5 hours ago</td>
                                            <td><span class="badge bg-info">New</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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
    
    <script>
        // Initialize charts
        document.addEventListener('DOMContentLoaded', function() {
            // Sales Chart
            const salesCtx = document.getElementById('salesChart').getContext('2d');
            const salesChart = new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Monthly Sales',
                        data: [65, 59, 80, 81, 56, 55],
                        backgroundColor: 'rgba(40, 167, 69, 0.2)',
                        borderColor: 'rgba(40, 167, 69, 1)',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            
            // User Chart
            const userCtx = document.getElementById('userChart').getContext('2d');
            const userChart = new Chart(userCtx, {
                type: 'doughnut',
                data: {
                    labels: ['New Users', 'Regular Users', 'Premium Users'],
                    datasets: [{
                        data: [30, 50, 20],
                        backgroundColor: [
                            'rgba(0, 123, 255, 0.7)',
                            'rgba(23, 162, 184, 0.7)',
                            'rgba(255, 193, 7, 0.7)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true
                }
            });
        });
    </script>
</body>
</html>