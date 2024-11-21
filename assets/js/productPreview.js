function showProductPreview(product) {
    currentProduct = product;
    
    // Update modal content
    document.getElementById('previewImage').src = product.image;
    document.getElementById('previewName').textContent = product.name;
    document.getElementById('previewPrice').textContent = `₱${product.price.toFixed(2)}`;
    document.getElementById('quantityInput').value = 1;
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('productPreviewModal'));
    modal.show();
}

function updateQuantity(change) {
    const input = document.getElementById('quantityInput');
    const newValue = parseInt(input.value) + change;
    if (newValue >= 1) {
        input.value = newValue;
    }
}

function addToCart() {
    const quantity = parseInt(document.getElementById('quantityInput').value);
    // Implement your cart logic here
    alert(`Added ${quantity} ${currentProduct.name}(s) to cart`);
    // Close modal after adding to cart
    const modal = bootstrap.Modal.getInstance(document.getElementById('productPreviewModal'));
    modal.hide();
}

function showNotification(message) {
    const notification = document.getElementById('custom-notification');
    const messageElement = document.getElementById('notification-message');
    messageElement.textContent = message;
    notification.style.display = 'block';
    
    setTimeout(() => {
        notification.style.display = 'none';
    }, 3000);
}

function addToCart() {
    const isLoggedIn = false;
    
    if (!isLoggedIn) {
        const modal = bootstrap.Modal.getInstance(document.getElementById('productPreviewModal'));
        modal.hide();
        
        showNotification('Please login to add items to cart');
        
        setTimeout(() => {
            window.location.href = 'login.php';  // Redirect to login page
        }, 2000);
        return;
    }
    
    const quantity = document.getElementById('productQuantity').value;
    const productName = document.getElementById('modalProductName').textContent;
    
    showNotification(`Added ${quantity} ${productName}(s) to cart`);
    const modal = bootstrap.Modal.getInstance(document.getElementById('productPreviewModal'));
    modal.hide();
}