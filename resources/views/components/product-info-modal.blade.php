<div class="modal fade" id="productInfoModal" tabindex="-1" aria-labelledby="productInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productInfoModalLabel">Product Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <img id="modalProductImage" src="" class="img-fluid rounded" style="max-height: 300px;" alt="Product Image">
                </div>
                <h5 id="modalOrderNumber" class="text-muted">Order #: </h5>
                <h4 id="modalProductName" class="fw-bold"></h4>
                <p id="modalProductDescription" class="text-muted"></p>
                <p id="modalProductPrice" class="text-danger fw-bold"></p>
                 <p class="text-muted">Quantity: <span id="modalProductQuantity" class="fw-bold"></span></p>
                <p id="modalPaymentMethod" class="text-muted"></p>
            </div>
        </div>
    </div>
</div>

<script>
    function showProductInfoModal(order) {
        const modal = document.getElementById('productInfoModal');
        const productImage = document.getElementById('modalProductImage');
        const orderNumber = document.getElementById('modalOrderNumber');
        const productName = document.getElementById('modalProductName');
        const productDescription = document.getElementById('modalProductDescription');
        const productPrice = document.getElementById('modalProductPrice');
        const productQuantity = document.getElementById('modalProductQuantity');
        const paymentMethod = document.getElementById('modalPaymentMethod');

        // Set modal content
        productImage.src = order.product.image
            ? `{{ asset('storage/') }}/${order.product.image}` 
            : '{{ asset("storage/default-product.png") }}';
        orderNumber.textContent = `Order #: ${order.order_no}`;
        productName.textContent = 'Product: ' + order.product.name;
        productDescription.textContent = '- ' + (order.product.description ? order.product.description : 'No description available');
        productPrice.textContent = `Price: ₱${parseFloat(order.product.price).toFixed(2)}`;
        productQuantity.textContent = order.quantity;
        paymentMethod.textContent = `Payment Method: ${order.payment_method ? order.payment_method.toUpperCase() : 'N/A'}`;
        // Show modal
        const bootstrapModal = new bootstrap.Modal(modal);
        bootstrapModal.show();
    }

    // Add event listener for modal close button
    document.querySelector('.btn-close').addEventListener('click', function() {
        const modal = document.getElementById('productInfoModal');
        const modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();
        // Remove modal backdrop
        document.querySelector('.modal-backdrop').remove();
        // Remove modal-open class from body
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
    });
</script>
