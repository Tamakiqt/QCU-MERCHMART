// Shop

document.addEventListener('DOMContentLoaded', function() {
    // Products array
    const products = [
        {
            id: 1,
            name: "QCU PE Uniform",
            price: 450,
            originalPrice: 599,
            image: "assets/images/beced.PNG",
            category: "pe",
        },
        {
            id: 2,
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
            id: 3,
            name: "QCU Cap",
            price: 199,
            originalPrice: 299,
            discount: "33%",
            image: "assets/images/bis.PNG",
            category: "accessories",
            sales: "300+ sold",
            rating: 4.6
        },
        {
            id: 4,
            name: "QCU Mug",
            price: 149,
            originalPrice: 199,
            discount: "25%",
            image: "assets/images/bsa.PNG",
            category: "accessories",
            sales: "200+ sold",
            rating: 4.7
        }
        // Add more products as needed
    ];

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
                <div class="card h-100">
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




