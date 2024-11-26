//Notif for add to cart!
document.addEventListener("DOMContentLoaded", function() {
    const addToFavoritesBtn = document.getElementById("addToFavoritesBtn");
    const addToCartBtn = document.getElementById("addToCart");
    const favoritesNotification = document.getElementById("notification");  // Favorite notification
    const cartNotification = document.getElementById("cartNotification");  // Cart notification

    // Show notification for 'Add to Favorites' button
    addToFavoritesBtn.addEventListener("click", function() {
        favoritesNotification.classList.add("show");
        setTimeout(function() {
            favoritesNotification.classList.remove("show");
        }, 3000);
    });

   
    addToCartBtn.addEventListener("click", function() {
        cartNotification.classList.add("show");
        setTimeout(function() {
            cartNotification.classList.remove("show");
        }, 3000);
    });
});



//Notif for favorite
document.addEventListener("DOMContentLoaded", function() {
    const addToFavoritesBtn = document.getElementById("addToFavoritesBtn");
    const notification = document.getElementById("notification");

    
    addToFavoritesBtn.addEventListener("click", function() {
     
        notification.classList.add("show");

       
        setTimeout(function() {
            notification.classList.remove("show");
        }, 3000);
    });
});




// Input button
document.addEventListener("DOMContentLoaded", function() {
   
    const quantityInput = document.getElementById("quantityInput");
    const decreaseBtn = document.getElementById("decreaseBtn");
    const increaseBtn = document.getElementById("increaseBtn");

   
    const minQuantity = 1; // Minimum quantity allowed
    const maxQuantity = 99; // Maximum quantity allowed

  
    decreaseBtn.addEventListener("click", function() {
        let currentQuantity = parseInt(quantityInput.value);
        if (currentQuantity > minQuantity) {
            currentQuantity -= 1; // Decrease by 1
            quantityInput.value = currentQuantity; // Update the input field
        }
    });

    
    increaseBtn.addEventListener("click", function() {
        let currentQuantity = parseInt(quantityInput.value);
        if (currentQuantity < maxQuantity) {
            currentQuantity += 1; // Increase by 1
            quantityInput.value = currentQuantity; // Update the input field
        }
    });

   
    quantityInput.addEventListener("input", function() {
        let inputValue = parseInt(quantityInput.value);
        if (isNaN(inputValue)) {
            quantityInput.value = minQuantity; // Set to min if it's not a valid number
        } else {
            // Ensure the value is within the min/max range
            if (inputValue < minQuantity) {
                quantityInput.value = minQuantity;
            } else if (inputValue > maxQuantity) {
                quantityInput.value = maxQuantity;
            }
        }
    });
});



// Slide button


const imagePaths = [
    "assets/images/IMG_0052.PNG", // Main image (index 0)
    "assets/images/bcs.PNG",
    "assets/images/beced.PNG",
    "assets/images/bis.PNG", 
    "assets/images/bsa.PNG",
    "assets/images/bscpe.PNG", 
    "assets/images/bsece.PNG",
    "assets/images/bsentrep.PNG", 
    "assets/images/bsie.PNG", 
    "assets/images/bsit.PNG", 
    "assets/images/bsma.PNG"
];

let currentIndex = 0;


function changeImage(index) {
    currentIndex = index;
    const mainImage = document.getElementById("main-image");
    mainImage.src = imagePaths[currentIndex];
}


function changeSlide(direction) {
    currentIndex += direction;
   
    if (currentIndex < 0) currentIndex = imagePaths.length - 1;
    if (currentIndex >= imagePaths.length) currentIndex = 0;

    const mainImage = document.getElementById("main-image");
    mainImage.src = imagePaths[currentIndex];
}

 // favorite icon 

document.addEventListener("DOMContentLoaded", function () {
    const favoriteBtn = document.getElementById("Favorite");
    const notification = document.getElementById("favoriteNotification");

    favoriteBtn.addEventListener("click", function () {
        // Toggle the 'favorited' class on the button
        favoriteBtn.classList.toggle("favorited");

        // Display the notification
        notification.classList.add("show");

        // Hide the notification after 2 seconds
        setTimeout(function () {
            notification.classList.remove("show");
        }, 3000);
    });
});

//For course choices

const courseSelect = document.getElementById('courseSelect');
const mainImage = document.getElementById('main-image');

courseSelect.addEventListener('change', function() {
    const selectedCourse = courseSelect.value;
    let newImageSrc = '';

    switch (selectedCourse) {
        case 'bcs':
            newImageSrc = 'assets/images/bcs.PNG';
            break;
        case 'beced':
            newImageSrc = 'assets/images/beced.PNG';
            break;
        case 'bis':
            newImageSrc = 'assets/images/bis.PNG';
            break;
        case 'bsa':
            newImageSrc = 'assets/images/bsa.PNG';
            break;
        case 'bscpe':
            newImageSrc = 'assets/images/bscpe.PNG';
            break;
        case 'bsece':
            newImageSrc = 'assets/images/bsece.PNG';
            break;
        case 'bsentrep':
            newImageSrc = 'assets/images/bsentrep.PNG';
            break;
        case 'bsie':
            newImageSrc = 'assets/images/bsie.PNG';
            break;
        case 'bsit':
            newImageSrc = 'assets/images/bsit.PNG';
            break;
        case 'bsma':
            newImageSrc = 'assets/images/bsma.PNG';
            break;
        default:
            newImageSrc = 'assets/images/IMG_0052.PNG'; // Default image
    }

    mainImage.src = newImageSrc;
});


// Cart

// Update the total price and quantity
let totalPrice = 300; // Example initial price
let quantityInputs = document.querySelectorAll('.quantity-input');
let checkoutButton = document.querySelector('.checkout-btn');
let totalDisplay = document.querySelector('.total-checkout span');

function updateTotal() {
    let newTotal = 0;
    quantityInputs.forEach(input => {
        const price = parseFloat(input.closest('tr').querySelector('td:nth-child(4)').textContent.replace('₱', '').trim());
        const quantity = parseInt(input.value);
        newTotal += price * quantity;
    });
    totalDisplay.textContent = 'Total: ₱' + newTotal.toFixed(2);
}

// Increase and decrease buttons
document.querySelectorAll('.increase-btn').forEach(button => {
    button.addEventListener('click', (e) => {
        let input = e.target.closest('tr').querySelector('.quantity-input');
        input.value = parseInt(input.value) + 1;
        updateTotal();
    });
});

document.querySelectorAll('.decrease-btn').forEach(button => {
    button.addEventListener('click', (e) => {
        let input = e.target.closest('tr').querySelector('.quantity-input');
        if (input.value > 1) {
            input.value = parseInt(input.value) - 1;
            updateTotal();
        }
    });
});

// Remove item
document.querySelectorAll('.remove-btn').forEach(button => {
    button.addEventListener('click', (e) => {
        e.target.closest('tr').remove();
        updateTotal();
    });
});


// My account upload profile picture 

function updateProfileImage(event) {
    const file = event.target.files[0];
    const reader = new FileReader();

    reader.onloadend = function() {
        const profileImage = document.getElementById("profile-image");
        const defaultIcon = document.getElementById("default-icon");

        // Hide the default icon
        defaultIcon.style.display = "none";

        // Show the uploaded image
        profileImage.src = reader.result;
        profileImage.style.display = "inline-block"; // Make the uploaded image visible
    };

    if (file) {
        reader.readAsDataURL(file);
    }
}



 
 

// Notif for client-index.php

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

// Edit and delete function fo my cart 

function toggleEdit(itemId) {
    const cartItem = document.getElementById('cartItem-' + itemId);
    const editQuantityInput = document.getElementById('edit-quantity-' + itemId);
    const displayQuantity = document.getElementById('display-quantity-' + itemId);
    const decreaseButton = document.getElementById('decrease-' + itemId);
    const increaseButton = document.getElementById('increase-' + itemId);

    // Toggle edit mode
    const isEditing = editQuantityInput.style.display === 'inline';

    if (isEditing) {
        // If it's already in editing mode, turn it off
        editQuantityInput.style.display = 'none';
        displayQuantity.style.display = 'inline';
        decreaseButton.disabled = true;
        increaseButton.disabled = true;
    } else {
        // If it's not in editing mode, enable editing
        editQuantityInput.style.display = 'inline';
        displayQuantity.style.display = 'none';
        decreaseButton.disabled = false;
        increaseButton.disabled = false;
    }
}

// Function to update the quantity when clicked
function updateQuantity(itemId, action) {
    const editQuantityInput = document.getElementById('edit-quantity-' + itemId);
    let currentQuantity = parseInt(editQuantityInput.value);

    // Increase or decrease the quantity
    if (action === 'increase') {
        currentQuantity++;
    } else if (action === 'decrease' && currentQuantity > 1) {
        currentQuantity--;
    }

    // Update the quantity input field
    editQuantityInput.value = currentQuantity;
    const displayQuantity = document.getElementById('display-quantity-' + itemId);
    displayQuantity.textContent = currentQuantity;

    // Send AJAX request to update quantity in the database
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'cart-update/edit_cart.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        let response = JSON.parse(xhr.responseText);
        if (response.status === 'success') {
            console.log('Quantity updated');
        } else {
            alert(response.message); // Show error message if failed
        }
    };
    xhr.send('item_id=' + itemId + '&quantity=' + currentQuantity);
}

// Attach event listener to the edit button
document.querySelectorAll('.edit-button').forEach(button => {
    button.addEventListener('click', function () {
        const itemId = this.closest('.cart-item1').getAttribute('data-item-id');
        toggleEdit(itemId);
    });
});

// Delete cart 

function removeFromCart(itemId) {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'cart-update/remove_cart.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Add an event listener to handle the response
    xhr.onload = function () {
        let response = JSON.parse(xhr.responseText);

        if (response.status === 'success') {
            // Remove the item from the DOM
            document.getElementById('cartItem-' + itemId).remove();
            alert('Item removed successfully');
        } else {
            alert(response.message || 'Failed to remove item');
        }
    };

    // Send the request with item_id
    xhr.send('item_id=' + itemId);
}



// Password 
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('register-form');
    const passwordInput = document.getElementById('register-password');
    const confirmPasswordInput = document.getElementById('register-confirm-password');

    function validatePassword(password) {
        // Password requirements regex
        const minLength = 8;
        const maxLength = 12;
        const hasUpperCase = /[A-Z]/.test(password);
        const hasLowerCase = /[a-z]/.test(password);
        const hasNumbers = /\d/.test(password);
        const hasSpecialChar = /[!@#$%^&*]/.test(password);
        
        if (password.length < minLength || password.length > maxLength) {
            return 'Password must be between 8 and 12 characters';
        }
        if (!hasUpperCase) {
            return 'Password must contain at least one uppercase letter';
        }
        if (!hasLowerCase) {
            return 'Password must contain at least one lowercase letter';
        }
        if (!hasNumbers) {
            return 'Password must contain at least one number';
        }
        if (!hasSpecialChar) {
            return 'Password must contain at least one special character (!@#$%^&*)';
        }
        return '';
    }

    form.addEventListener('submit', function(e) {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        
        // Validate password
        const passwordError = validatePassword(password);
        if (passwordError) {
            e.preventDefault();
            alert(passwordError);
            return;
        }

        // Check if passwords match
        if (password !== confirmPassword) {
            e.preventDefault();
            alert('Passwords do not match');
            return;
        }
    });
});