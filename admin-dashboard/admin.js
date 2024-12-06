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
