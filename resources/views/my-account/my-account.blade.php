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
                            <option>Delivered</option>
                            <option>In Progress</option>
                            <option>Delayed</option>
                            <option>Canceled</option>
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
                                <tr>
                                    <td><a class="text-primary text-decoration-none" href="#order-details">78A643CD409</a></td>
                                    <td>August 08, 2017</td>
                                    <td><span class="badge bg-danger">Canceled</span></td>
                                    <td>$760.50</td>
                                </tr>
                                <tr>
                                    <td><a class="text-primary text-decoration-none" href="#order-details">34VB5540K83</a></td>
                                    <td>July 21, 2017</td>
                                    <td><span class="badge bg-info">In Progress</span></td>
                                    <td>$315.20</td>
                                </tr>
                                <tr>
                                    <td><a class="text-primary text-decoration-none" href="#order-details">112P45A90V2</a></td>
                                    <td>June 15, 2017</td>
                                    <td><span class="badge bg-warning">Delayed</span></td>
                                    <td>$1,264.00</td>
                                </tr>
                                <tr>
                                    <td><a class="text-primary text-decoration-none" href="#order-details">28BA67U0981</a></td>
                                    <td>May 19, 2017</td>
                                    <td><span class="badge bg-success">Delivered</span></td>
                                    <td>$198.35</td>
                                </tr>
                                <tr>
                                    <td><a class="text-primary text-decoration-none" href="#order-details">502TR872W2</a></td>
                                    <td>April 04, 2017</td>
                                    <td><span class="badge bg-success">Delivered</span></td>
                                    <td>$2,133.90</td>
                                </tr>
                                <tr>
                                    <td><a class="text-primary text-decoration-none" href="#order-details">47H76G09F33</a></td>
                                    <td>March 30, 2017</td>
                                    <td><span class="badge bg-success">Delivered</span></td>
                                    <td>$86.40</td>
                                </tr>
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