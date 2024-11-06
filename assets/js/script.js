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
    "assets/images/IMG_0041.PNG",
    "assets/images/IMG_0042.PNG",
    "assets/images/IMG_0043.PNG",
    "assets/images/IMG_0044.PNG",
    "assets/images/IMG_0045.PNG",
    "assets/images/IMG_0046.PNG",
    "assets/images/IMG_0047.PNG",
    "assets/images/IMG_0048.PNG",
    "assets/images/IMG_0049.PNG",
    "assets/images/IMG_0050.PNG"
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

