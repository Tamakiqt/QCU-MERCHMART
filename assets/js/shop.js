
    // Products array
    const products = [
        {
            id: 1,
            name: "Tumbler (Violet)",
            price: 250,
            image: "../uploads/product_67565263363751.16010069.PNG",
            category: "tumblers"
        },

        {
            id: 2,
            name: "Tumblers (Red)",
            price: 250,
            image: "../uploads/product_675654da3989a2.18568684.PNG",
            category: "tumblers"
        },

        {
            id: 3,
            name: "Bachelor of Science in Computer Science (BCS)",
            price: 75,
            image: "../uploads/product_67569f53364787.30492816.PNG",
            category: "lace"
        },

        {
            id: 4,
            name: "Bachelor of Science in Management Accounting (BSMA)",
            price: 75,
            image: "../uploads/product_67569cc76d70c2.80101398.PNG",
            category: "lace"
        },

        {
            id: 5,
            name: "Bachelor of Science in Entrepreneurship (BSENTREP)",
            price: 75,
            image: "../uploads/product_67569da8188136.71205525.PNG",
            category: "lace"
        },

        {
            id: 6,
            name: "Bachelor of Science in Information Systems (BIS)",
            price: 75,
            image: "../uploads/product_67569e2a5db551.81571066.PNG",
            category: "lace"
        },

        {
            id: 7,
            name: "Bachelor of Early Childhood Education (BECED)",
            price: 75,
            image: "../uploads/product_67569f13208980.41388595.PNG",
            category: "lace"
        },

        {
            id: 8,
            name: "Bachelor of Science Computer Science (BCS)",
            price: 75,
            image: "../uploads/product_67569f53364787.30492816.PNG",
            category: "lace"
        },
        
        {
            id: 9,
            name: "Bachelor of Science in Information Technology (BSIT)",
            price: 75,
            image: "../uploads/product_67569fb1816d59.50711803.PNG",
            category: "lace"
        },

        {
            id: 10,
            name: "Bachelor of Science in Electronics Engineering (BSECE)",
            price: 75,
            image: "../uploads/product_67569ffedacad5.92496251.PNG",
            category: "lace"
        },

        {
            id: 11,
            name: "Bachelor of Science in Industrial Engineering (BSIE)",
            price: 75,
            image: "../uploads/product_6756a036cd9a36.55822817.PNG",
            category: "lace"
        },

        {
            id: 12,
            name: "Bachelor of Science in Accountancy (BSA)",
            price: 75,
            image: "../uploads/product_6756a0a5a60160.67885630.PNG",
            category: "lace"
        },

        {
            id: 13,
            name: "NSTP Shirt",
            price: 250,
            image: "../uploads/product_6756a1213beec2.83624615.png",
            category: "college"
        },
        {
            id: 14,
            name: "P.E Shirt",
            price: 250,
            image: "../uploads/product_6756a1928f62c5.33368374.png",
            category: "pe"
           
        },

        {
            id: 15,
            name: "CBAA Shirt",
            price: 199,
            image: "../uploads/product_6756a1ffdec678.71267709.png",
            category: "college"
           
        },


        {
            id: 16,
            name: "Female Blouse",
            category: "college",
            image: "../uploads/product_6756a2323aa864.81991127.png",
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
            id: 17,
            name: "Male Polo",
            category: "college",
            image: "../uploads/product_6756a2593dd7d9.05310333.png",
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
            id: 18,
            name: "Male Pants",
            category: "college",
            image: "../uploads/product_6756a2884826f7.79784606.png",
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
            id: 19,
            name: "Jacket (Black)",
            category: "jackets",
            image: "../uploads/product_6756a310aa2f59.85803338.png",
            sizePricing: {
                'XS': 600,
                'S': 600,
                'M': 600,
                'L': 600,
                'XL': 600
            },
            defaultPrice: 600
        },

        {
            id: 20,
            name: "Tissue",
            price: 15,
            image: "../uploads/product_675cad4025f6c5.75342426.png",
            category: "tissue"
        },

        {
            id: 21,
            name: "Wipes",
            price: 30,
            image: "../uploads/product_675cae1e1166b3.24573004.png",
            category: "wipes"
        },

        {
            id: 22,
            name: "JPIA (Junior Philippine Institute of Accountance)",
            price: 450,
            image: "../uploads/1734127789_IMG_20241108_151238_284-removebg-preview.png",
            category: "department"
        },

        {
            id: 23,
            name: "ID Holder",
            price: 30,
            image: "../uploads/product_675cb1184cd991.94736803.png",
            category: "holder"
        },

        {
            id: 24,
            name: "Hair clip (Flower)",
            price: 25,
            image: "../uploads/product_675cb1df4abc34.63390838.png",
            category: "clip"
        },

        {
            id: 25,
            name: "Hair Clutchers",
            price: 25,
            image: "../uploads/product_675cb2ad73e470.69371842.png",
            category: "clutcher"
        },

        {
            id: 26,
            name: "Umbrella (Red)",
            price: 170,
            image: "../uploads/product_675cb4bd7bb4c1.01469657.png",
            category: "umbrella"
        },

       

       

        
        // Add more products as needed
    ];

// Move these functions outside the DOMContentLoaded event
function handleProductClick(productId) {
    const product = products.find(p => p.id === productId);
    if (product) {
        const modal = document.getElementById('productPreviewModal');
        modal.setAttribute('data-product-id', product.id);
        
        // Fetch stock quantity from server
        fetch(`get-product-stock.php?id=${productId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showProductPreview(
                        product.name, 
                        product.sizePricing ? product.defaultPrice : product.price,
                        product.image, 
                        product.category,
                        data.stock_quantity
                    );
                } else {
                    console.error('Error:', data.message);
                    showProductPreview(product.name, product.price, product.image, product.category, 0);
                }
            })
            .catch(error => {
                console.error('Error fetching stock:', error);
                showProductPreview(product.name, product.price, product.image, product.category, 0);
            });
    }
}
    

function updateQuantity(action) {
    const quantityInput = document.getElementById('productQuantity');
    const currentStock = parseInt(document.getElementById('modalProductStock').textContent);
    let currentValue = parseInt(quantityInput.value);

    if (action === 'increase') {
        if (currentValue < currentStock) {
            currentValue++;
        } else {
            alert('Cannot exceed available stock');
            return;
        }
    } else if (action === 'decrease') {
        if (currentValue > 1) {
            currentValue--;
        }
    }

    quantityInput.value = currentValue;
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
        

function showProductPreview(name, price, imageUrl, category, stockQuantity) {
    const modal = document.getElementById('productPreviewModal');
    const modalInstance = new bootstrap.Modal(modal);
    const sizeSelection = document.querySelector('.modal-body .mb-3:has(.size-options)');
    const variantSelection = document.querySelector('.modal-body .mb-3:has(.form-select)');
    const descriptionElement = document.getElementById('modalProductDescription');
    
    // Find the product
    const product = products.find(p => p.name === name);   
    
    
    
    // NEW CODE: Update stock display and handle out of stock state
    document.getElementById('modalProductStock').textContent = stockQuantity;
    const addToCartBtn = modal.querySelector('.add-cart');
    const buyNowBtn = modal.querySelector('.buy-now');
    
    if (stockQuantity <= 0) {
        addToCartBtn.disabled = true;
        addToCartBtn.textContent = 'Out of Stock';
        buyNowBtn.disabled = true;
        // Disable quantity controls
        document.querySelector('.quantity-btn[onclick="decreaseQuantity()"]').disabled = true;
        document.querySelector('.quantity-btn[onclick="increaseQuantity()"]').disabled = true;
        document.getElementById('productQuantity').disabled = true;
    } else {
        addToCartBtn.disabled = false;
        addToCartBtn.textContent = 'Add to Cart';
        buyNowBtn.disabled = false;
        // Enable quantity controls
        document.querySelector('.quantity-btn[onclick="decreaseQuantity()"]').disabled = false;
        document.querySelector('.quantity-btn[onclick="increaseQuantity()"]').disabled = false;
        document.getElementById('productQuantity').disabled = false;
    }
    // END OF NEW CODE
    
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
                case 'tumblers':  // Add this new case
                    descriptionElement.textContent = "The QCU TUMBLER collection features a colorful selection of durable, functional water bottles, emphasizing variety, quality, and style.";
                    break;
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
                    ${product.stock_quantity <= 0 ? '<div class="out-of-stock-overlay">Out of Stock</div>' : ''}
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


//Delete Favorite
function deleteFavorite(favoriteId) {
    // Get the modal
    const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
    const confirmBtn = document.getElementById('confirmDelete');
    
    // Remove any existing click handlers
    confirmBtn.replaceWith(confirmBtn.cloneNode(true));
    
    // Get fresh reference to the button
    const newConfirmBtn = document.getElementById('confirmDelete');
    
    // Add click handler
    newConfirmBtn.addEventListener('click', function() {
        fetch('delete-favorite.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                favorite_id: favoriteId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Hide the modal
                modal.hide();
                
                // Remove the item from the DOM
                const favoriteItem = document.getElementById(`favorite-${favoriteId}`);
                favoriteItem.classList.add('removing');
                
                setTimeout(() => {
                    favoriteItem.remove();
                    
                    // Check if there are any favorites left
                    const favoritesContainer = document.querySelector('.favorites-row');
                    if (favoritesContainer.children.length === 0) {
                        // Show the "No favorites" message
                        favoritesContainer.innerHTML = `
                            <div class="col-12 text-center" style="margin-top: 50px;">
                                <div class="no-favorites d-flex justify-content-center align-items-center flex-column">
                                    <i class="bi bi-heart" style="font-size: 3rem; color: #6c757d;"></i>
                                    <p class="mt-3 mb-2">No favorites yet</p>
                                    <a href="client-shop.php" class="btn btn-primary">Go Shopping</a>
                                </div>
                            </div>
                        `;
                    }
                }, 300);
                
                showNotification('Item removed from favorites');
            } else {
                showNotification('Error removing item from favorites');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error removing item from favorites');
        });
    });
    
    // Show the modal
    modal.show();
}








