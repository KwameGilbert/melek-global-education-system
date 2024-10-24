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


// Function to load the dashboard data
function loadDashboard() {
    console.log('Dashboard loaded!');

    // Fetch the data from the JSON file
    fetch('./api/dashboard.json')
        .then(response => response.json())
        .then(data => {
            // Populate application and payment status
            document.getElementById('application-status').innerText = data.applicationStatus;
            document.getElementById('payment-status').innerText = data.paymentStatus;

            // Populate notices with date and time
            const noticesList = document.getElementById('notices-list');
           
            data.notices.forEach(notice => {
                const noticeItem = document.createElement('div');
                noticeItem.classList.add('p-2', 'mb-2', 'bg-white', 'rounded', 'shadow');

                // Create a message container
                const message = document.createElement('p');
                message.innerText = notice.message;

                // Create a date container
                const date = document.createElement('small');
                date.classList.add('block', 'text-gray-500', 'text-sm');
                date.innerText = `Posted on: ${notice.date}`;

                // Append message and date to the notice item
                noticeItem.appendChild(message);
                noticeItem.appendChild(date);

                // Append the notice item to the list
                noticesList.appendChild(noticeItem);
            });
        })
        .catch(error => {
            console.error('Error fetching dashboard data:', error);
        });
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


// Load the selected page and inject the content into the main-content area
function loadPage(page) {
    fetch(`./pages/${page}`)
        .then(response => response.text())
        .then(html => {
            const mainContent = document.getElementById('main-content');
            mainContent.innerHTML = html;
            console.log(page);

            // Call the respective function based on the loaded page
            switch (page) {
                case 'dashboard.html':
                    console.log(page)
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


