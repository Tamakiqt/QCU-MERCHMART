
    // Products array
    const products = [
        {
            id: 1,
            name: "Bachelor of Science Computer Science (BCS)",
            price: 70,
            image: "assets/images/bcs.PNG",
            category: "lace"
        },

        {
            id: 2,
            name: "Bachelor of Early Childhood Education (BECED)",
            price: 70,
            image: "assets/images/beced.PNG",
            category: "lace"
        },

        {
            id: 3,
            name: "Bachelor of Science in Information Systems (BIS)",
            price: 70,
            image: "assets/images/bis.PNG",
            category: "lace"
        },

        {
            id: 4,
            name: "Bachelor of Science in Accountancy (BSA)",
            price: 70,
            image: "assets/images/bsa.PNG",
            category: "lace"
        },

        {
            id: 5,
            name: "Bachelor of Science in Computer Engineering (BSCPE)",
            price: 70,
            image: "assets/images/bscpe.PNG",
            category: "lace"
        },

        {
            id: 6,
            name: "Bachelor of Science in Electronics Engineering (BSECE)",
            price: 70,
            image: "assets/images/bsece.PNG",
            category: "lace"
        },

        {
            id: 7,
            name: "Bachelor of Science in Entrepreneurship (BSENTREP)",
            price: 70,
            image: "assets/images/bsentrep.PNG",
            category: "lace"
        },

        {
            id: 8,
            name: "Bachelor of Science in Industrial Engineering (BSIE)",
            price: 70,
            image: "assets/images/bsie.PNG",
            category: "lace"
        },
        
        {
            id: 9,
            name: "Bachelor of Science in Information Technology (BSIT)",
            price: 70,
            image: "assets/images/bsit.PNG",
            category: "lace"
        },

        {
            id: 10,
            name: "Bachelor of Science in Management Accounting (BSMA)",
            price: 70,
            image: "assets/images/bsma.PNG",
            category: "lace"
        },

        {
            id: 11,
            name: "Jacket",
            price: 50,
            image: "assets/images/jacket.png",
            category: "jackets"
        },
        {
            id: 12,
            name: "CBAA Shirt",
            price: 199,
            image: "assets/images/cbaa.png",
            category: "college"
           
        }
        
        // Add more products as needed
    ];

// Move these functions outside the DOMContentLoaded event
function handleProductClick(productId) {
    const product = products.find(p => p.id === productId);
    if (product) {
        showProductPreview(product);
    }
}

function updateQuantity(change) {
    const input = document.getElementById('productQuantity');
    let value = parseInt(input.value) + change;
    if (value >= 1) {
        input.value = value;
    }
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

function showProductPreview(productId, name, price, imageUrl) {
    const modal = new bootstrap.Modal(document.getElementById('productPreviewModal'));
    
    document.getElementById('modalProductName').textContent = name;
    document.getElementById('modalProductPrice').textContent = `₱${price}`;
    document.getElementById('modalProductImage').src = imageUrl;
    document.getElementById('productQuantity').value = 1;
    
    modal.show();
}

function increaseQuantity() {
    const quantityInput = document.getElementById('productQuantity');
    quantityInput.value = parseInt(quantityInput.value) + 1;
}

function decreaseQuantity() {
    const quantityInput = document.getElementById('productQuantity');
    if (parseInt(quantityInput.value) > 1) {
        quantityInput.value = parseInt(quantityInput.value) - 1;
    }
}

// Move displayProducts function outside of DOMContentLoaded
function displayProducts(filteredProducts = products) {
    const container = document.getElementById('products-container');
    if (!container) {
        console.error('Products container not found!');
        return;
    }

    // Clear existing content
    container.innerHTML = '';

    if (filteredProducts.length === 0) {
        container.innerHTML = `
            <div class="col-12">
                <div class="no-products d-flex justify-content-center align-items-center text-center" style="height: 70vh;">
                    <div>
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No products found</p>
                        <p class="text-muted small">Try different keywords or check your spelling</p>
                    </div>
                </div>
            </div>`;
        return;
    }

    // Display filtered products
        container.innerHTML = filteredProducts.map(product => `
            <div class="col">
                <div class="card h-100" onclick="handleProductClick(${product.id})" style="cursor: pointer;">
                    <div class="image-container position-relative">
                        <img src="${product.image}" 
                            class="card-img-top" 
                            alt="${product.name}"
                            onerror="this.src='https://via.placeholder.com/150'">
                        <div class="image-line"></div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title" title="${product.name}">${product.name}</h5>
                        <div class="price-section">
                            <span class="text-danger fw-bold">₱${product.price.toFixed(2)}</span>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
}

// Search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            const query = searchInput.value.toLowerCase().trim();

            const filteredProducts = products.filter(product => 
                product.name.toLowerCase().includes(query) || 
                (product.category && product.category.toLowerCase().includes(query))
            );

            displayProducts(filteredProducts);
            console.log('Search query:', query);
            console.log('Filtered products:', filteredProducts);
        });
    }

    // Category filtering
    document.querySelectorAll('.category-link, .subcategory-menu a').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const category = e.target.dataset.category;
            const filteredProducts = category === 'all' 
                ? products 
                : products.filter(product => product.category === category);
            displayProducts(filteredProducts);
        });
    });

    // Sort handling
    const sortSelect = document.getElementById('sortSelect');
    if (sortSelect) {
        sortSelect.addEventListener('change', (e) => {
            let sortedProducts = [...products];
            switch(e.target.value) {
                case 'priceLow':
                    sortedProducts.sort((a, b) => a.price - b.price);
                    break;
                case 'priceHigh':
                    sortedProducts.sort((a, b) => b.price - a.price);
                    break;
                case 'topSales':
                    sortedProducts.sort((a, b) => {
                        const aSales = parseInt(a.sales) || 0;
                        const bSales = parseInt(b.sales) || 0;
                        return bSales - aSales;
                    });
                    break;
            }
            displayProducts(sortedProducts);
        });
    }

    // Initial display
    displayProducts();
});



// Price js 









