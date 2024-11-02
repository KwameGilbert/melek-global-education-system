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
    const view_all_notices = document.getElementById('view-all-notices');

        view_all_notices.addEventListener('click', function (event) {
            event.preventDefault();
            const page = view_all_notices.getAttribute('data-page');
            localStorage.setItem('activePage', page);
            loadPage(page);
        });

    
    fetch('./api/application.json')
        .then(response => response.json())
        .then(data => {
            // Populate application and payment status
            document.getElementById('application-status').innerText = data.applicationStatus;
            document.getElementById('payment-status').innerText = data.paymentStatus;
        })
        .catch(error => {
            console.error('Error fetching dashboard data:', error);
        });

    fetch('./api/notices.json')
        .then(response => response.json())
        .then(data => {
            // Populate notices with date and time
            const noticesList = document.getElementById('notices-list');
            noticesList.innerText = '';

            if (data.length === 0) {
                noticesList.innerText = 'No notices available';
                return;
            }

            data.forEach(notice => {
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
        }
    );
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

    //JavaScript to Add More Entries  
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

    async function populateFormOptions() {
        // Fetch countries and nationalities from Rest Countries API
        try {
            const responseCountries = await fetch('./api/countries_list.json');
            const countriesData = await responseCountries.json();

            const nationalityInput = document.getElementById("nationality");
            const countryOfBirthInput = document.getElementById("country-birth");

            countriesData.forEach(country => {
                // Add options for nationality and country of birth
                let nationalityOption = document.createElement("option");
                nationalityOption.value = country;
                nationalityOption.text = country;
                nationalityInput.add(nationalityOption);

                let countryOption = document.createElement("option");
                countryOption.value = country;
                countryOption.text = country;
                countryOfBirthInput.add(countryOption);

                let countryOfCorrespondenceOption = document.createElement("option");
                countryOfCorrespondenceOption.value = country;
                countryOfCorrespondenceOption.text = country;
                document.getElementById("country-correspondence").add(countryOfCorrespondenceOption);

                let countryOfResidenceOption = document.createElement("option");
                countryOfResidenceOption.value = country;
                countryOfResidenceOption.text = country;
                document.getElementById("country-residence").add(countryOfResidenceOption);
            });
        } catch (error) {
            console.error('Error fetching countries and nationalities:', error);
        }

    }

    // Populate religion options with a custom list
    const religions = ["Christianity", "Islam", "Hinduism", "Buddhism", "Sikhism", "Judaism", "Atheism", "Other"];
    const religionInput = document.getElementById("religion");

    religions.forEach(religion => {
        let religionOption = document.createElement("option");
        religionOption.value = religion;
        religionOption.text = religion;
        religionInput.add(religionOption);
    });

populateFormOptions();

}

function loadPayments() {
    console.log('Payments page loaded!');
    // Add code to handle payments here
      function showPaymentForm() {
            const paymentMethod = document.getElementById("payment-method").value;
            const forms = document.querySelectorAll(".payment-form");

            forms.forEach(form => form.classList.add("hidden"));
            if (paymentMethod) {
                document.getElementById(`${paymentMethod}-form`).classList.remove("hidden");
            }
        }

    document.getElementById("payment-method").addEventListener("change", showPaymentForm);
}

function loadProfile() {
    console.log('Profile page loaded!');
    // Add code to handle profile data here
}

function loadNoticesPage() {
    console.log('Updates page loaded!');
    // Add code to handle updates here
    // Fetch notices from JSON
    async function loadNotices() {
        try {
            const response = await fetch('./api/notices.json');
            const notices = await response.json();
            // Display notices
            displayNotices(notices);
        } catch (error) {
            console.error("Failed to load notices:", error);
        }
    }

    // Display notices with a preview format
    function displayNotices(notices) {
        const noticesList = document.getElementById('notices-list');
        noticesList.innerHTML = '';

        if (notices.length === 0) {
            noticesList.innerHTML = '<p class="text-gray-500 text-lg">No notices available</p>';
            return;
        }

        notices.forEach(notice => {
            const noticeItem = document.createElement('div');
            noticeItem.className = 'p-4 bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow cursor-pointer';

            noticeItem.innerHTML = `
            <div class="flex justify-between items-center">
                <h2 class="font-medium text-lg text-gray-800 truncate">${notice.title}</h2>
                <span class="text-sm text-gray-500">${notice.date}</span>
            </div>
            <p class="text-gray-600 mt-1 truncate">${notice.message.substring(0, 50)}...</p>
        `;

            // Show modal with notice details on click
            noticeItem.onclick = () => showNoticeModal(notice);

            noticesList.appendChild(noticeItem);
        });
    }

    // Show full notice details in modal
    function showNoticeModal(notice) {
        document.getElementById('modal-title').textContent = notice.title;
        document.getElementById('modal-message').textContent = notice.message;
        document.getElementById('modal-date').textContent = `Date: ${notice.date} | Time: ${notice.time}`;

        const modal = document.getElementById('notice-modal');
        modal.classList.remove('hidden');
    }

    // Close modal
    function closeModal() {
        document.getElementById('notice-modal').classList.add('hidden');
    }

    // Event listeners
    document.getElementById('close-modal').onclick = closeModal;
    document.getElementById('notice-modal').onclick = event => {
        if (event.target === event.currentTarget) closeModal();
    };

    // Load notices on page load
    loadNotices();

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
                case 'notices.html':
                    loadNoticesPage();
                    break;
                default:
                    console.error('No matching function for the page:', page);
            }
        })
        .catch(error => console.error('Error loading page:', error));
}
