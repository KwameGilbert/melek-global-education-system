// Add event listeners to all sidebar links
document.querySelectorAll('a[data-page]').forEach(link => {
    link.addEventListener('click', function (event) {
        event.preventDefault();
        const page = this.getAttribute('data-page'); // Fetch the data-page value
        // Save the selected page in localStorage
        localStorage.setItem('activePage', page);
        loadPage(page); // Call the loadPage function
    });
});

// Load the selected page and inject the content into the main-content area
function loadPage(page) {
    fetch(`./pages/${page}`)
        .then(response => response.text())
        .then(html => {
            const mainContent = document.getElementById('main-content');
            mainContent.innerHTML = html;

            // Call the respective function based on the loaded page
            switch (page) {
                case 'dashboard.html':
                    loadDashboard();
                    break;
                case 'applications.html':
                    loadApplications();
                    break;
                case 'payments.html':
                    loadPayments();
                    break;
                case 'profile.html':
                    loadProfile();
                    break;
                case 'updates.html':
                    loadUpdates();
                    break;
                default:
                    console.error('No matching function for the page:', page);
            }
        })
        .catch(error => console.error('Error loading page:', error));
}

// On page load, check localStorage and load the appropriate page
window.onload = function () {
    const activePage = localStorage.getItem('activePage') || 'dashboard.html'; // Default to 'dashboard.html'
    loadPage(activePage);
};


// Example functions for each page
function loadDashboard() {
    console.log('Dashboard loaded!');
    // Add code to populate the dashboard here
}

function loadApplications() {
    console.log('Applications page loaded!');
    // Add code to handle applications data here
}

function loadPayments() {
    console.log('Payments page loaded!');
    // Add code to handle payments here
}

function loadProfile() {
    console.log('Profile page loaded!');
    // Add code to handle profile data here
}

function loadUpdates() {
    console.log('Updates page loaded!');
    // Add code to handle updates here
}
