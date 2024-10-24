// Load the selected page into the main content area
function loadPage(page) {
    const mainContent = document.getElementById('main-content');
    fetch('../dashboard/pagges', page)
        .then(response => response.text())
        .then(html => {
            mainContent.innerHTML = html;
            // Execute page-specific scripts after loading
            if (page === 'dashboard.html') {
                loadDashboard();
            } else if (page === 'applications.html') {
                loadApplications();
            }
            // Add similar checks for other pages
        })
        .catch(err => console.error('Error loading page:', err));
}

// On page load, display the dashboard by default
window.onload = function () {
    loadPage('dashboard.html');
};
