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
    const form = document.getElementById('application-form');
    const submitBtn = document.getElementById('submit-btn');
    const saveBtn = document.getElementById('save-btn');

    form.addEventListener('input', checkFormCompletion);

    function checkFormCompletion() {
        const isComplete = Array.from(form.elements).every(input => {
            return input.type === "file" ? input.files.length > 0 : input.value.trim() !== "";
        });
        submitBtn.disabled = !isComplete;
        submitBtn.classList.toggle('bg-blue-500', isComplete);
        submitBtn.classList.toggle('bg-gray-300', !isComplete);
        submitBtn.classList.toggle('cursor-not-allowed', !isComplete);
    }

    saveBtn.addEventListener('click', () => {
        alert('Form data saved temporarily!');
    });

    submitBtn.addEventListener('click', (e) => {
        e.preventDefault();
        if (form.checkValidity()) {
            alert('Form submitted successfully!');
            form.reset();
            checkFormCompletion();
        } else {
            alert('Please fill out all required fields.');
        }
    });


     
        // <!-- JavaScript to Add More Entries -->
    
            document.getElementById('add-study-entry').addEventListener('click', () => {
                const studyContainer = document.getElementById('study-experience-container');
                const newEntry = document.createElement('div');
                newEntry.className = 'study-entry grid grid-cols-1 md:grid-cols-2 gap-4 mt-4';
                newEntry.innerHTML = `
                    <h2 class="text-xl font-bold text-gray-700">Next School</h2>
                    <br>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">School Name *</label>
                        <input type="text" class="school-name w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Degree *</label>
                        <input type="text" class="degree w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Year of Attendance (From - To) *</label>
                        <input type="text" class="attendance-period w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Contact Person</label>
                        <input type="text" class="contact-person w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400">
                    </div>
                `;
                studyContainer.appendChild(newEntry);
            });

            document.getElementById('add-work-entry').addEventListener('click', () => {
                const workContainer = document.getElementById('work-history-container');
                const newEntry = document.createElement('div');
                newEntry.className = 'work-entry grid grid-cols-1 md:grid-cols-2 gap-4 mt-4';
                newEntry.innerHTML = `
                     <h2 class="text-xl font-bold text-gray-700">Next Work Experience</h2>
                    <br>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Starting Time</label>
                        <input type="date" class="work-start w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Ending Time</label>
                        <input type="date" class="work-end w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Occupation</label>
                        <input type="text" class="occupation w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Company</label>
                        <input type="text" class="company w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Phone/Mobile</label>
                        <input type="tel" class="phone w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Email</label>
                        <input type="email" class="email w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400">
                    </div>
                `;
                workContainer.appendChild(newEntry);
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


