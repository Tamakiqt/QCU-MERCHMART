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


document.getElementById('register-form').addEventListener('submit', function(e) {
    var password = document.getElementById('register-password').value;
    var confirmPassword = document.getElementById('register-confirm-password').value;

    if (password !== confirmPassword) {
        e.preventDefault(); // Prevent form submission
        alert('Passwords do not match!');
    }
});


// Google sign in login 

function onGoogleSignIn(googleUser) {
    // Get the user’s profile information
    var profile = googleUser.getBasicProfile();
    var email = profile.getEmail();  // Get email
    var id = profile.getId();  // Get Google ID

    // Send this data to your server for processing
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'server/social_login.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.responseText === 'Success') {
            window.location.href = 'index.html';  // Redirect on successful login
        } else {
            alert('Error: ' + xhr.responseText);
        }
    };
    xhr.send('email=' + email + '&id=' + id + '&platform=google');
}

// Initialize Facebook SDK
window.fbAsyncInit = function() {
    FB.init({
        appId      : 'YOUR_APP_ID',  // Replace with your Facebook app ID
        cookie     : true,
        xfbml      : true,
        version    : 'v12.0'
    });
};

// Check the login state of the user
function checkLoginState() {
    FB.getLoginStatus(function(response) {
        if (response.status === 'connected') {
            // User is logged in
            FB.api('/me', {fields: 'id,email,name'}, function(response) {
                // Send this data to your server
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'server/social_login.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (xhr.responseText === 'Success') {
                        window.location.href = 'index.html';  // Redirect on successful login
                    } else {
                        alert('Error: ' + xhr.responseText);
                    }
                };
                xhr.send('email=' + response.email + '&id=' + response.id + '&platform=facebook');
            });
        }
    });
}

