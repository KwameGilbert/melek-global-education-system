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


function loadAdminDashboard() {
    console.log('Admin Dashboard Loaded');

    function generateChart() {
        // Initialize Chart.js with dummy data
        const ctx = document.getElementById('applicationsChart').getContext('2d');
        const applicationsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Applicants', 'Admitted', 'Processing', 'Rejected', 'Pending Payment', 'Pending Processing'],
                datasets: [{
                    label: 'Applications Status',
                    data: [408, 207, 112, 19, 35, 23],
                    backgroundColor: [
                        'rgba(250, 87, 0, 0.7)',
                        'rgba(5, 198, 131, 0.7)',
                        'rgba(219, 0, 69, 0.7)',
                        'rgba(0, 92, 197, 0.7)',
                        'rgba(92, 41, 0, 0.7)',
                        'rgba(174, 0, 209, 0.7)'
                    ],
                    borderColor: [
                        'rgba(250, 87, 0, 1)',
                        'rgba(5, 198, 131, 1)',
                        'rgba(219, 0, 69, 1)',
                        'rgba(0, 92, 197, 1)',
                        'rgba(92, 41, 0, 1)',
                        'rgba(174, 0, 209, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#333'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#333'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    generateChart();
};

function loadApplicants(){
    console.log('Applicants loaded successfully');

    let applicantData = [];

    async function fetchApplicants() {
        try {
            const response = await fetch('applicants.json');
            applicantData = await response.json();
            populateTable(applicantData);
            populateFilterOptions();
        } catch (error) {
            console.error("Failed to load applicants data:", error);
        }
    }

    function populateTable(data) {
        const table = document.getElementById('applicantsTable');
        table.innerHTML = data.map(applicant => `
            <tr>
                <td class="p-4 border-b">${applicant.name}</td>
                <td class="p-4 border-b">${applicant.applicantId}</td>
                <td class="p-4 border-b">${applicant.school}</td>
                <td class="p-4 border-b">${applicant.program}</td>
                <td class="p-4 border-b">${applicant.dateApplied}</td>
                <td class="p-4 border-b">${applicant.status}</td>
                <td class="p-4 border-b"><button class="text-blue-500">View</button></td>
            </tr>
        `).join('');
    }

    function populateFilterOptions() {
        const filterColumn = document.getElementById('filterColumn');
        const filterValue = document.getElementById('filterValue');

        filterColumn.addEventListener('change', () => {
            const column = filterColumn.value;
            const values = [...new Set(applicantData.map(a => a[column]))];
            filterValue.innerHTML = '<option value="">Select Value</option>' +
                values.map(value => `<option value="${value}">${value}</option>`).join('');
        });

        filterValue.addEventListener('change', filterTable);
    }

    function filterTable() {
        const searchQuery = document.getElementById('searchInput').value.toLowerCase();
        const filterColumn = document.getElementById('filterColumn').value;
        const filterValue = document.getElementById('filterValue').value;

        const filteredData = applicantData.filter(applicant => {
            const matchesSearch = applicant.name.toLowerCase().includes(searchQuery) ||
                applicant.applicantId.toLowerCase().includes(searchQuery);
            const matchesFilter = !filterColumn || !filterValue || applicant[filterColumn] === filterValue;
            return matchesSearch && matchesFilter;
        });

        populateTable(filteredData);
    }

    document.getElementById('searchInput').addEventListener('input', filterTable);

    fetchApplicants();

    // Search Functionality
    document.getElementById("search").addEventListener("input", function () {
        const searchValue = this.value.toLowerCase();
        const filteredData = data.filter(applicant => applicant.name.toLowerCase().includes(searchValue) || applicant.applicantId.toLowerCase().includes(searchValue));
        populateTable(filteredData);
    });

    // Sort Table

    let sortOrder = true;
    function sortTable(column) {
        const sortedData = [...data].sort((a, b) => {
            if (a[column] < b[column]) return sortOrder ? -1 : 1;
            if (a[column] > b[column]) return sortOrder ? 1 : -1;
            return 0;
        });
        sortOrder = !sortOrder;
        populateTable(sortedData);
    }

    document.querySelectorAll('th[data-column]').forEach(link => {
        link.addEventListener('click', function () {
            const column = this.getAttribute('data-column');
            sortTable(column);
        })
    })

};

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
                    loadAdminDashboard();
                    break;
                case 'applicants.html':
                    loadApplicants();
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
};
