// Select the sidebar and toggle button
const toggleSidebarButton = document.getElementById("toggleSidebar");
const sidebar = document.getElementById("sidebar");
const overlay = document.getElementById("overlay");  // if you have an overlay to hide the sidebar

// Add click event listener to the toggle button
toggleSidebarButton.addEventListener("click", () => {
  // Toggle the "active" class on the sidebar to show/hide it
  sidebar.classList.toggle("active");
  
  // If you're using an overlay, toggle its visibility as well
  overlay.classList.toggle("active");
});




function selectProduct(card) {
    // Toggle selected class
    card.classList.toggle('selected');
}

// Highlight the active link
document.addEventListener('DOMContentLoaded', function () {
    const currentSection = new URLSearchParams(window.location.search).get('section');

    // Reset all links
    document.getElementById('dashboardLink').classList.remove('active-link');
    document.getElementById('productsLink').classList.remove('active-link');
    document.getElementById('ordersLink').classList.remove('active-link');
    document.getElementById('customersLink').classList.remove('active-link');
    document.getElementById('statisticsLink').classList.remove('active-link');
    document.getElementById('settingsLink').classList.remove('active-link');

    // Highlight the active link based on the current section
    if (currentSection === 'products') {
        document.getElementById('productsLink').classList.add('active-link');
    } else if (currentSection === 'orders') {
        document.getElementById('ordersLink').classList.add('active-link');
    } else if (currentSection === 'customers') {
        document.getElementById('customersLink').classList.add('active-link');
    } else if (currentSection === 'statistics') {
        document.getElementById('statisticsLink').classList.add('active-link');
    } else if (currentSection === 'settings') {
        document.getElementById('settingsLink').classList.add('active-link');
    } else {
        document.getElementById('dashboardLink').classList.add('active-link');
    }
});

//buttons for delete and edit
function toggleButtons(card) {
    const buttons = card.querySelector('.action-buttons');
    buttons.style.display = buttons.style.display === 'none' ? 'block' : 'none';
}

// Add Product
document.addEventListener('DOMContentLoaded', function() {
    // Test if modal trigger is working
    const addButton = document.querySelector('[data-bs-target="#addProductModal"]');
    addButton.addEventListener('click', function() {
        console.log('Add button clicked');
        const modal = new bootstrap.Modal(document.getElementById('addProductModal'));
        modal.show();
    });
});

// Add Product
document.addEventListener('DOMContentLoaded', function() {
    // Image preview
    const productPicture = document.getElementById('productPicture');
    const imagePreview = document.createElement('img');
    imagePreview.style.maxWidth = '200px';
    imagePreview.style.marginTop = '10px';
    
    productPicture.after(imagePreview);
    
    productPicture.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            imagePreview.style.display = 'none';
        }
    });

    // Form validation
    const addProductForm = document.getElementById('addProductForm');
    addProductForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const productName = document.getElementById('productName').value;
        const price = document.getElementById('price').value;
        const category = document.getElementById('category').value;
        const stockQuantity = document.getElementById('stockQuantity').value;
        
        if (!productName || !price || !category || !stockQuantity) {
            alert('Please fill in all required fields');
            return;
        }
        
        if (!productPicture.files[0]) {
            alert('Please select a product image');
            return;
        }
        
        this.submit();
    });
});

// Function to reset form and preview when modal is closed
$('#addProductModal').on('hidden.bs.modal', function () {
    document.getElementById('addProductForm').reset();
    document.querySelector('#productPicture + img').style.display = 'none';
});


document.addEventListener('DOMContentLoaded', function() {
    // Add click event listeners to all delete buttons
    const deleteButtons = document.querySelectorAll('.delete-btn');

    
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            
            if (confirm('Are you sure you want to delete this product?')) {
                // Send delete request
                fetch('delete_product.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'product_id=' + productId
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Remove the product card from the DOM
                        this.closest('.col-12').remove();
                        alert('Product deleted successfully!');
                    } else {
                        alert('Error deleting product: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting product');
                });
            }
        });
    });
    
});

button.addEventListener('click', function() {
    const productId = this.getAttribute('data-id');
    console.log('Delete button clicked for product ID:', productId);
    
    if (confirm('Are you sure you want to delete this product?')) {
        console.log('Sending delete request for product ID:', productId);
    }
});


// Function to show notification
function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
    notification.style.zIndex = '9999';
    notification.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} me-2"></i>
            <strong>${message}</strong>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    document.getElementById('notificationContainer').appendChild(notification);
    
    setTimeout(() => notification.remove(), 3000);
}

// Function to edit product
function editProduct(productId) {
    // Show loading state
    console.log('Fetching product data for ID:', productId);
    
    fetch(`get_product.php?id=${productId}`)
        .then(response => response.json())
        .then(product => {
            console.log('Received product data:', product);
            
            // Populate form fields
            document.getElementById('editProductId').value = product.id;
            document.getElementById('editProductName').value = product.product_name;
            document.getElementById('editDescription').value = product.description;
            document.getElementById('editPrice').value = product.price;
            document.getElementById('editCategory').value = product.category;
            document.getElementById('editStockQuantity').value = product.stock_quantity;
            
            // Update image preview
            const currentImage = document.getElementById('currentProductImage');
            if (product.image_url) {
                currentImage.src = product.image_url;
                currentImage.style.display = 'block';
            } else {
                currentImage.style.display = 'none';
            }
            
            // Show the modal
            const editModal = new bootstrap.Modal(document.getElementById('editProductModal'));
            editModal.show();
        })
        .catch(error => {
            console.error('Error fetching product:', error);
            showNotification('Error loading product details', 'danger');
        });
}

// Handle form submission
document.addEventListener('DOMContentLoaded', function() {
    const editForm = document.getElementById('editProductForm');
    
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Create FormData object
            const formData = new FormData(this);
            
            // Debug: Log form data
            for (let [key, value] of formData.entries()) {
                console.log(`${key}: ${value}`);
            }
            
            // Send AJAX request
            fetch('edit_product.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log('Server response:', data);
                
                if (data.status === 'success') {
                    // Show success message
                    showNotification('Product updated successfully!', 'success');
                    
                    // Close the modal
                    const editModal = bootstrap.Modal.getInstance(document.getElementById('editProductModal'));
                    editModal.hide();
                    
                    // Refresh the page after a short delay
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    // Show error message
                    showNotification(data.message || 'Error updating product', 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error updating product. Please try again.', 'danger');
            });
        });
    }
});

// Preview new image when selected
document.getElementById('editProductPicture').addEventListener('change', function(e) {
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('currentProductImage').src = e.target.result;
        };
        reader.readAsDataURL(this.files[0]);
    }
});
