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
    // JavaScript to handle form navigation and API fetch calls

    let currentStep = 1;
    const totalSteps = 5;

    // Show/hide sections based on the current step
    function showStep(step) {
        document.querySelectorAll('.section').forEach((section, index) => {
            section.classList.toggle('hidden', index + 1 !== step);
        });
    }

    // Event listeners for Next and Previous buttons
    document.getElementById('next-btn').addEventListener('click', () => {
        if (currentStep < totalSteps) {
            currentStep++;
            showStep(currentStep);
            updateNavigation();
        }
    });

    document.getElementById('prev-btn').addEventListener('click', () => {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
            updateNavigation();
        }
    });

    function updateNavigation() {
        document.getElementById('prev-btn').disabled = currentStep === 1;
        document.getElementById('next-btn').textContent = currentStep === totalSteps ? 'Submit' : 'Next';
    }

    // Initial load
    showStep(currentStep);
    updateNavigation();

    // Example API call to populate nationality dropdown
    async function fetchCountries() {
        const response = await fetch('https://restcountries.com/v3.1/all');
        const countries = await response.json();
        const nationalityDropdown = document.getElementById('nationality');
        countries.forEach(country => {
            const option = document.createElement('option');
            option.value = country.name.common;
            option.textContent = country.name.common;
            nationalityDropdown.appendChild(option);
        });
    }

    // Call the API to fetch and populate dropdowns on load
    fetchCountries();
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


