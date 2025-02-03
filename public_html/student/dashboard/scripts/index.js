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

    // Show loading state
    const loadingToast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    loadingToast.fire({
        title: 'Loading your Dashboard...',
        timer: 3000,
        timerProgressBar: true
    });

    const view_all_notices = document.getElementById('view-all-notices');

    view_all_notices.addEventListener('click', function (event) {
        event.preventDefault();
        const page = view_all_notices.getAttribute('data-page');
        localStorage.setItem('activePage', page);
        loadPage(page);
    });


    fetch('../../../api/student/application/application.php')
        .then(response => response.json())
        .then(data => {
            // Populate application and payment status
            document.getElementById('applicant-id').innerText = data.applicantID;
            document.getElementById('application-status').innerText = data.applicationStatus;
            document.getElementById('payment-status').innerText = data.paymentStatus;
        })
        .catch(error => {
            console.error('Error fetching dashboard data:', error);
        });


    fetch('../../../api/student/notice/notices.php')
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

function loadPayments() {
    console.log('Payments page loaded!');
      // Show loading state
   const loadingToast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
});

loadingToast.fire({
    title: 'Loading your payments...',
    timer: 3000,
    timerProgressBar: true
});
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
      // Show loading state
   const loadingToast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
});

loadingToast.fire({
    title: 'Loading your Profile Page...',
    timer: 3000,
    timerProgressBar: true
});

    initializeProfilePage();
}

function loadNoticesPage() {
    console.log('Updates page loaded!');
      // Show loading state
   const loadingToast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
});

loadingToast.fire({
    title: 'Loading your Updates...',
    timer: 3000,
    timerProgressBar: true
});
    // Add code to handle updates here
    // Fetch notices from JSON
    async function loadNotices() {
        try {
            const response = await fetch('../../../api/student/notice/notices.php');
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
                case 'application.php':
                    loadApplications();
                    break;
                case 'payments.php':
                    initiatePayment();
                    break;
                case 'profile.php':
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

async function logout() {
    try {
        const response = await fetch('../../../api/logout/logout.php', {
            method: 'GET'
        });

        if (response.ok) {
            // Redirect to login page
            Swal.fire({
                title: "Success",
                text: "Logout successful",
                icon: "success",
                showConfirmButton: false,
                allowOutsideClick: false,
            })
            window.location.href = '../login/index.php';
        } else {
            // Show error message
            Swal.fire({
                title: "Error!",
                text: "Failed to log out. Please try again.",
                icon: "error",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "OK"
            });
        }
    } catch (error) {
        console.log(error);
        Swal.fire({
            title: "Error!",
            text: "An unexpected error occurred. Please try again.",
            icon: "error",
            confirmButtonColor: "#3085d6",
            confirmButtonText: "OK"
        });
    }
}