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

