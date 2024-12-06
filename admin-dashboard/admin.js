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
    // Debug: Log to confirm the script is running
    console.log('Delete buttons script loaded');
    
    // Select all delete buttons
    const deleteButtons = document.querySelectorAll('.delete-btn');
    console.log('Found delete buttons:', deleteButtons.length);
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-id');
            console.log('Delete clicked for product ID:', productId);
            
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
                    console.log('Server response:', data);
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
