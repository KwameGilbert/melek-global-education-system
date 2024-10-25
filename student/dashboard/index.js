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
           
            if (data.notices) {
                noticesList.innerText = '';
            }
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

    // Fetch the application data from a JSON file or API
    fetch('./api/application.json')
        .then(response => response.json())
        .then(data => {
            const applicationStatus = document.getElementById('application-status');
            const applyNowSection = document.getElementById('apply-now-section');
            const existingApplicationsSection = document.getElementById('existing-applications-section');
            const applicationsList = document.getElementById('applications-list');

            // If no applications, show "Apply Now" button
            if (data.applications.length === 0) {
                applicationStatus.innerText = "No Applications";
                applyNowSection.classList.remove('hidden');
                existingApplicationsSection.classList.add('hidden');
            } else {
                // If applications exist, hide "Apply Now" button and show the applications
                applyNowSection.classList.add('hidden');
                existingApplicationsSection.classList.remove('hidden');

                applicationStatus.innerText = `${data.applications.length} Application(s)`;

                // Populate the applications list
                applicationsList.innerHTML = ''; // Clear any existing content
                data.applications.forEach(application => {
                    const appItem = document.createElement('div');
                    appItem.classList.add('p-4', 'bg-white', 'rounded', 'shadow');

                    const appDetails = `
                                <p><strong>Program:</strong> ${application.program}</p>
                                <p><strong>Status:</strong> ${application.status}</p>
                                <p><strong>Submitted on:</strong> ${application.submissionDate}</p>
                                <p><strong>Current Stage:</strong> ${application.currentStage}</p>
                            `;

                    appItem.innerHTML = appDetails;
                    applicationsList.appendChild(appItem);
                });
            }
        })
        .catch(error => {
            console.error('Error fetching application data:', error);
        });
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
                    loadDashboard();
                    break;
                case 'application.html':
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


