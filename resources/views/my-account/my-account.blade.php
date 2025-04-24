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
                        <option value="approved">Approved</option>
                        <option value="pending">Pending</option>
                        <option value="in progress">In Progress</option>
                        <option value="delivered">Delivered</option>
                        <option value="rejected">Rejected</option>
                        <option value="canceled">Canceled</option>
                    </select>
                </div>

                @include('components.product-info-modal')

                <div class="table-responsive">
                    <table class="table table-hover table-bordered text-center">
                        <thead class="table-dark">
                        <tr>
                            <th>Order #</th>
                            <th>Refund No</th>
                            <th>Date Purchased</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody class="text-start">
                        @foreach($orders as $order)
                            <tr>
                                <td><a href="#" class="text-decoration-none">{{ $order->order_no }}</a></td>
                                <td>
                                    @if($order->refund_no)
                                        <a href="#" class="text-decoration-none">{{ $order->refund_no }}</a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                <td>{{ $order->created_at->format('F j, Y') }}</td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'approved' => 'success',
                                            'pending' => 'warning text-dark',
                                            'in progress' => 'info',
                                            'delivered' => 'primary',
                                            'rejected' => 'danger',
                                            'canceled' => 'danger',
                                            'refunded' => 'dark',
                                            'refund_requested' => 'warning',
                                            'refund_rejected' => 'danger',
                                        ];
                                        $statusLabel = ucwords(str_replace('_', ' ', $order->status));
                                    @endphp
                                    <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td>₱{{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    <div class="btn-group gap-1">
                                        <button class="btn btn-primary btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#productInfoModal"
                                                onclick='showProductInfoModal(@json($order))'>
                                            <i class="fa fa-eye"></i> View
                                        </button>

                                        @php
                                            $restrictedRefundStatuses = ['refund_requested', 'refunded', 'refund_rejected'];
                                            $canRequestRefund = $order->status === 'delivered' && !in_array($order->status, $restrictedRefundStatuses);
                                        @endphp

                                        <button class="btn btn-sm {{ $canRequestRefund ? 'btn-warning' : 'btn-secondary text-muted' }}"
                                                {{ $canRequestRefund ? '' : 'disabled' }}
                                                data-bs-toggle="modal"
                                                data-bs-target="#refundRequestModal"
                                                onclick='showRefundModal(@json($order))'>
                                            <i class="fa fa-undo"></i> Request Refund
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div> <!-- End Main Container -->
        </div> <!-- End Orders Table -->

    </div>
</div>

<!-- Refund Request Modal -->
<div class="modal fade" id="refundRequestModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark sticky-top">
                <h5 class="modal-title d-flex align-items-center">
                    <i class="fa fa-undo me-2"></i>
                    Request Refund
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="refundRequestForm" action="{{ route('orders.request-refund') }}" method="POST" class="needs-validation" novalidate>
                @csrf
                <input type="hidden" name="order_id" id="refundOrderId">
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                    <div class="card mb-3 border-secondary">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Order Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <div class="d-flex justify-content-between">
                                        <strong>Order #:</strong>
                                        <span id="refundOrderNo"></span>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <strong>Date Purchased:</strong>
                                        <span id="refundOrderDate"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="d-flex justify-content-between">
                                        <strong>Total Amount:</strong>
                                        <span id="refundOrderAmount"></span>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <strong>Payment Method:</strong>
                                        <span id="refundPaymentMethod"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Refund Reason -->
                    <div class="mb-3">
                        <label for="refundReason" class="form-label fw-bold">Reason for Refund</label>
                        <textarea class="form-control" id="refundReason" name="refund_reason" 
                                  rows="4" required minlength="10"
                                  placeholder="Please provide a detailed explanation for your refund request..."></textarea>
                        <div class="invalid-feedback">
                            Please provide a detailed reason (minimum 10 characters).
                        </div>
                    </div>

                    <div class="alert alert-info shadow-sm">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fa fa-info-circle me-2"></i>
                            <strong>Please note:</strong>
                        </div>
                        <ul class="mb-0 ps-4">
                            <li>Refund requests are subject to review and approval</li>
                            <li>Processing may take 3–5 business days</li>
                            <li>You will be notified once your request is processed</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer sticky-bottom">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fa fa-paper-plane me-1"></i>
                        Submit Refund Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function showRefundModal(order) {
        console.log(order);
        document.getElementById('refundOrderId').value = order.id;
        document.getElementById('refundOrderNo').textContent = order.order_no;
        document.getElementById('refundOrderDate').textContent = new Date(order.created_at).toLocaleDateString();
        document.getElementById('refundOrderAmount').textContent = '₱' + parseFloat(order.total_amount).toLocaleString(undefined, {
            minimumFractionDigits: 2
        });
        document.getElementById('refundPaymentMethod').textContent = order.payment_method.toUpperCase();
    }

    // Handle form validation
    (function () {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation')
        Array.from(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })();

    // Handle success flash message
    @if(session('success'))
    alert("{{ session('success') }}");
    @endif
</script>

</body>
</html>
