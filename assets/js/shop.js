
    // Products array
    const products = [
        {
            id: 1,
            name: "QCU Lanyards",
            price: 70,
            image: "assets/images/bcs.PNG",
            category: "lace",
        },

        {
            id: 2,
            name: "QCU Lanyards",
            price: 70,
            image: "assets/images/bcs.PNG",
            category: "lace",
        },

        {
            id: 3,
            name: "QCU Lanyards",
            price: 70,
            image: "assets/images/bcs.PNG",
            category: "lace",
        },

        {
            id: 4,
            name: "QCU Lanyards",
            price: 70,
            image: "assets/images/bcs.PNG",
            category: "lace",
        },

        {
            id: 5,
            name: "QCU Lanyards",
            price: 70,
            image: "assets/images/bcs.PNG",
            category: "lace",
        },

        {
            id: 6,
            name: "QCU Lanyards",
            price: 70,
            image: "assets/images/bcs.PNG",
            category: "lace",
        },

        {
            id: 7,
            name: "QCU Lanyards",
            price: 70,
            image: "assets/images/bcs.PNG",
            category: "lace",
        },

        {
            id: 8,
            name: "QCU Lanyards",
            price: 70,
            image: "assets/images/bcs.PNG",
            category: "lace",
        },
        
        {
            id: 9,
            name: "QCU Lanyards",
            price: 70,
            image: "assets/images/bcs.PNG",
            category: "lace",
        },

        {
            id: 10,
            name: "QCU Lanyards",
            price: 70,
            image: "assets/images/bcs.PNG",
            category: "lace",
        },

        {
            id: 11,
            name: "QCU ID Lace",
            price: 50,
            originalPrice: 75,
            discount: "33%",
            image: "assets/images/IMG_0052.PNG",
            category: "accessories",
            sales: "500+ sold",
            rating: 4.5
        },
        {
            id: 12,
            name: "QCU Cap",
            price: 199,
            originalPrice: 299,
            discount: "33%",
            image: "assets/images/bis.PNG",
            category: "accessories",
            sales: "300+ sold",
            rating: 4.6
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

// DOM Content Loaded Event
document.addEventListener('DOMContentLoaded', function() {
    // Display products function
    function displayProducts(filteredProducts = products) {
        const container = document.getElementById('products-container');
        if (!container) {
            console.error('Products container not found!');
            return;
        }
    
        if (filteredProducts.length === 0) {
            container.innerHTML = `
                <div class="no-products d-flex justify-content-center align-items-center text-center" style="height: 70vh; margin-left: 50px;">
                    <div>
                        <i class="fas fa-frown fa-3x text-muted"></i>
                        <p class="text-muted mt-3">No products found <br> Try different or more general keywords</p>
                    </div>
                </div>`;
            return;
        }
    
        container.innerHTML = filteredProducts.map(product => `
            <div class="col">
                <div class="card h-100" onclick="handleProductClick(${product.id})" style="cursor: pointer;">
                    ${product.discount ? `<div class="badge bg-danger position-absolute top-0 start-0 m-2">-${product.discount}</div>` : ''}
                    <div class="image-container position-relative">
                        <img src="${product.image}" 
                             class="card-img-top" 
                             alt="${product.name}"
                             onerror="this.src='https://via.placeholder.com/150'">
                        <div class="image-line"></div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">${product.name}</h5>
                        <div class="price-section">
                            <span class="text-danger fw-bold">₱${product.price.toFixed(2)}</span>
                            ${product.originalPrice ? `
                                <small class="text-decoration-line-through text-muted ms-2">₱${product.originalPrice.toFixed(2)}</small>
                            ` : ''}
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
    }

         // Search functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keyup', () => {
            const query = searchInput.value.toLowerCase();

            const filteredProducts = products.filter(product => 
                product.name.toLowerCase().includes(query) || 
                product.category.toLowerCase().includes(query)
            );

            displayProducts(filteredProducts);
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
                    sortedProducts.sort((a, b) => parseInt(b.sales) - parseInt(a.sales));
                    break;
            }
            displayProducts(sortedProducts);
        });
    }

    // Initial display
    displayProducts();
});

// Price js 









