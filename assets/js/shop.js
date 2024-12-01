
    // Products array
    const products = [
        {
            id: 1,
            name: "Bachelor of Science Computer Science (BCS)",
            price: 75,
            image: "assets/images/bcs.PNG",
            category: "lace"
        },

        {
            id: 2,
            name: "Bachelor of Early Childhood Education (BECED)",
            price: 75,
            image: "assets/images/beced.PNG",
            category: "lace"
        },

        {
            id: 3,
            name: "Bachelor of Science in Information Systems (BIS)",
            price: 75,
            image: "assets/images/bis.PNG",
            category: "lace"
        },

        {
            id: 4,
            name: "Bachelor of Science in Accountancy (BSA)",
            price: 75,
            image: "assets/images/bsa.PNG",
            category: "lace"
        },

        {
            id: 5,
            name: "Bachelor of Science in Computer Engineering (BSCPE)",
            price: 75,
            image: "assets/images/bscpe.PNG",
            category: "lace"
        },

        {
            id: 6,
            name: "Bachelor of Science in Electronics Engineering (BSECE)",
            price: 75,
            image: "assets/images/bsece.PNG",
            category: "lace"
        },

        {
            id: 7,
            name: "Bachelor of Science in Entrepreneurship (BSENTREP)",
            price: 75,
            image: "assets/images/bsentrep.PNG",
            category: "lace"
        },

        {
            id: 8,
            name: "Bachelor of Science in Industrial Engineering (BSIE)",
            price: 75,
            image: "assets/images/bsie.PNG",
            category: "lace"
        },
        
        {
            id: 9,
            name: "Bachelor of Science in Information Technology (BSIT)",
            price: 75,
            image: "assets/images/bsit.PNG",
            category: "lace"
        },

        {
            id: 10,
            name: "Bachelor of Science in Management Accounting (BSMA)",
            price: 75,
            image: "assets/images/bsma.PNG",
            category: "lace"
        },

        {
            id: 11,
            name: "Jacket",
            price: 600,
            image: "assets/images/jacket.png",
            category: "jackets"
        },
        {
            id: 12,
            name: "CBAA Shirt",
            price: 199,
            image: "assets/images/cbaa.png",
            category: "college"
           
        },

        {
            id: 13,
            name: "Male Polo",
            category: "college",
            image: "assets/images/male.png",
            sizePricing: {
                'XS': 470,
                'S': 470,
                'M': 470,
                'L': 470,
                'XL': 480
            },
            defaultPrice: 470
        },
        

        {
            id: 14,
            name: "Male Pants",
            category: "college",
            image: "assets/images/pants.png",
            sizePricing: {
                'XS': 570,
                'S': 570,
                'M': 570,
                'L': 570,
                'XL': 580
            },
            defaultPrice: 570
        },

        {
            id: 15,
            name: "Female Blouse",
            category: "college",
            image: "assets/images/female.png",
            sizePricing: {
                'XS': 470,
                'S': 470,
                'M': 470,
                'L': 470,
                'XL': 480
            },
            defaultPrice: 470
        },

        {
            id: 16,
            name: "NSTP Shirt",
            price: 250,
            image: "assets/images/nstp.png",
            category: "college"
           
        },

        {
            id: 17,
            name: "P.E Shirt",
            price: 250,
            image: "assets/images/p.e.png",
            category: "pe"
           
        }


        
        // Add more products as needed
    ];

// Move these functions outside the DOMContentLoaded event
function handleProductClick(productId) {
    const product = products.find(p => p.id === productId);
    if (product) {
        const modal = document.getElementById('productPreviewModal');
        modal.setAttribute('data-product-id', product.id);
        showProductPreview(product.name, product.price, product.image, product.category);
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

function addToCart(product) {
    // Log the product data for debugging
    console.log('Product data:', product);

    const formData = new FormData();
    formData.append('product_id', product.id);
    formData.append('product_name', product.name);
    formData.append('price', product.price);
    formData.append('quantity', product.quantity);
    formData.append('image_url', product.image);

    // Log the FormData (for debugging)
    for (let pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }

    fetch('add-to-cart.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log('Server response:', data); // Debug log
        if (data.status === 'success') {
            showNotification(`Added ${product.quantity} ${product.name}(s) to cart`);
            
            // Close modal if it's open
            const modal = document.getElementById('productPreviewModal');
            if (modal) {
                const modalInstance = bootstrap.Modal.getInstance(modal);
                if (modalInstance) {
                    modalInstance.hide();
                }
            }
            
            // Update cart icon
            updateCartIcon();
        } else {
            showNotification(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error adding to cart');
    });
}

function updateCartIcon() {
    fetch('get-cart-count.php')
        .then(response => response.json())
        .then(data => {
            const cartIcon = document.getElementById('CartIcon');
            if (cartIcon) {
                cartIcon.setAttribute('data-count', data.count);
                cartIcon.classList.toggle('has-items', data.count > 0);
            }
        })
        .catch(error => console.error('Error updating cart icon:', error));
}

 //Add to favorites

 function addToFavorites() {
    const isClientShop = window.location.pathname.includes('client-shop.php');
    
    if (isClientShop) {
        const productId = document.getElementById('productPreviewModal').getAttribute('data-product-id');
        const productName = document.getElementById('modalProductName').textContent;
        const productPrice = document.getElementById('modalProductPrice').textContent.replace('₱', '').trim();
        const productImage = document.getElementById('modalProductImage').src;

        // Send data to PHP endpoint
        fetch('add-to-favorites.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                product_id: productId,
                product_name: productName,
                price: productPrice,
                image_url: productImage
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(`${productName} added to favorites`);
                // Update heart icon
                const heartIcon = document.querySelector('.favorite-btn i');
                heartIcon.classList.remove('bi-heart');
                heartIcon.classList.add('bi-heart-fill');
            } else {
                showNotification(data.message);
            }
            const modal = bootstrap.Modal.getInstance(document.getElementById('productPreviewModal'));
            modal.hide();
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error adding to favorites');
        });
    } else {
        const modal = bootstrap.Modal.getInstance(document.getElementById('productPreviewModal'));
        modal.hide();
        
        showNotification('Please login to add items to favorites');
        
        setTimeout(() => {
            window.location.href = 'login.php';
        }, 2000);
    }
}
        

function showProductPreview(name, price, imageUrl, category, variants) {
    const modal = document.getElementById('productPreviewModal');
    const modalInstance = new bootstrap.Modal(modal);
    const sizeSelection = document.querySelector('.modal-body .mb-3:has(.size-options)');
    const variantSelection = document.querySelector('.modal-body .mb-3:has(.form-select)');
    const descriptionElement = document.getElementById('modalProductDescription');
    
    // Find the product
    const product = products.find(p => p.name === name);    
    
    // Define categories that should show size options
    const categoriesWithSize = ['college', 'pe', 'jackets', 'department', 'shirts'];
    const categoriesWithVariant = ['jackets'];
    // Show/hide size selection based on category           
    if (sizeSelection) {
        sizeSelection.style.display = categoriesWithSize.includes(category) ? 'block' : 'none';
    }
    if (variantSelection) {
        variantSelection.style.display = categoriesWithVariant.includes(category) ? 'block' : 'none';
    }

    
    // Update modal content
    document.getElementById('modalProductName').textContent = name;
    document.getElementById('modalProductImage').src = imageUrl;
    document.getElementById('productQuantity').value = 1;
    const priceElement = document.getElementById('modalProductPrice');

    // Handle size buttons and pricing
    const sizeButtons = document.querySelectorAll('.size-btn');
    
    // Remove old event listeners
    sizeButtons.forEach(btn => {
        const newBtn = btn.cloneNode(true);
        btn.parentNode.replaceChild(newBtn, btn);
    });

    // Get fresh reference to buttons after cloning
    const freshSizeButtons = document.querySelectorAll('.size-btn');
    
    if (product && product.sizePricing) {
        // Show initial price
        priceElement.textContent = `₱${product.defaultPrice}`;

        // Add click handlers to size buttons
        freshSizeButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from all buttons
                freshSizeButtons.forEach(b => b.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Get the size from the button text
                const selectedSize = this.textContent.trim(); // XS, S, M, L, XL
                
                // Update price based on selected size
                if (product.sizePricing[selectedSize]) {
                    const newPrice = product.sizePricing[selectedSize];
                    priceElement.textContent = `₱${newPrice}`;
                }
            });
        });
    } else {
        // For non-uniform products
        priceElement.textContent = `₱${price}`;
    }
     
    // Set description based on category and product name
    if (descriptionElement) {
        // Check for specific product first
        if (name.toLowerCase().includes('nstp shirt')) {
            descriptionElement.textContent = "The QCU NSTP T-shirt is a durable, breathable, and stylish green shirt with a patriotic red, white, and blue logo.";
        } else {
            // If not NSTP shirt, use category-based descriptions
            switch(category) {
                case 'lace':
                    descriptionElement.textContent = "The QCU Merch Lanyard collection combines style and durability, offering functional and fashionable lanyards for everyday or special use.";
                    break;
                case 'college':
                    descriptionElement.textContent = "The QCU Merch Uniform is a versatile blue shirt with a stylish design, suitable for both casual and professional settings, offering modern aesthetics and quality.";
                    break;
                case 'jackets':
                    descriptionElement.textContent = "This stylish jacket, with its prominent logo and sleek design, offers comfort, durability, and versatility for casual or semi-formal occasions, blending fashion with functionality.";
                    break;
                case 'pe':
                    descriptionElement.textContent = "The QCU P.E. T-Shirt is a durable, breathable yellow shirt designed for comfort, visibility, and team spirit during workouts.";
                    break;
                default:
                    descriptionElement.textContent = '';
            }
        }
    }

    modalInstance.show();
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

function updateCartIcon() {
    const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    const cartIcon = document.getElementById('CartIcon');
    if (cartIcon) {
        const itemCount = cartItems.reduce((total, item) => total + parseInt(item.quantity), 0);
        cartIcon.setAttribute('data-count', itemCount);
        cartIcon.classList.toggle('has-items', itemCount > 0);
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
                        <span class="text-danger fw-bold">
                            ${product.sizePricing 
                                ? `₱${product.defaultPrice.toFixed(2)}` 
                                : `₱${product.price.toFixed(2)}`}
                        </span>
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
    updateCartIcon();
    displayProducts();
});



// Price js 









