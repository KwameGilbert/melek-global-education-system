// Add event listeners to all sidebar links
document.querySelectorAll("a[data-page]").forEach((link) => {
  link.addEventListener("click", function (event) {
    event.preventDefault();
    const page = this.getAttribute("data-page"); // Fetch the data-page value
    // Save the selected page in localStorage
    localStorage.setItem("activePage", page);
    loadPage(page); // Call the loadPage function
  });
});

function loadAdminDashboard() {
  console.log("Admin Dashboard Loaded");

  // Initialize Chart.js with dummy data
  const ctx = document.getElementById("applicationsChart").getContext("2d");
  const applicationsChart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: [
        "Applicants",
        "Admitted",
        "Processing",
        "Rejected",
        "Pending Payment",
        "Pending Processing",
      ],
      datasets: [
        {
          label: "Applications Status",
          data: [408, 207, 112, 19, 35, 23],
          backgroundColor: [
            "rgba(250, 87, 0, 0.7)",
            "rgba(5, 198, 131, 0.7)",
            "rgba(219, 0, 69, 0.7)",
            "rgba(0, 92, 197, 0.7)",
            "rgba(92, 41, 0, 0.7)",
            "rgba(174, 0, 209, 0.7)",
          ],
          borderColor: [
            "rgba(250, 87, 0, 1)",
            "rgba(5, 198, 131, 1)",
            "rgba(219, 0, 69, 1)",
            "rgba(0, 92, 197, 1)",
            "rgba(92, 41, 0, 1)",
            "rgba(174, 0, 209, 1)",
          ],
          borderWidth: 1,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            color: "#333",
          },
        },
        x: {
          ticks: {
            color: "#333",
          },
        },
      },
      plugins: {
        legend: {
          display: false,
        },
      },
    },
  });
}

function loadApplicants() {
    console.log("Applicants loaded successfully");

    // Demo JSON data
    const data = [
      {
        name: "John Doe",
        applicantId: "A1234",
        school: "University A",
        program: "Engineering",
        dateApplied: "2023-07-18",
        status: "Pending",
      },
      {
        name: "Jane Smith",
        applicantId: "A5678",
        school: "University B",
        program: "Business",
        dateApplied: "2023-08-22",
        status: "Accepted",
      },
      {
        name: "Alice Johnson",
        applicantId: "A9012",
        school: "University C",
        program: "Arts",
        dateApplied: "2023-07-10",
        status: "Rejected",
      },
      {
        name: "Bob Brown",
        applicantId: "A3456",
        school: "University D",
        program: "Science",
        dateApplied: "2023-08-15",
        status: "Pending",
      },
      {
        name: "Gilbert Kukah",
        applicantId: "A1254",
        school: "University A",
        program: "Science",
        dateApplied: "2023-08-15",
        status: "Pending",
      },
    ];

    // Populate Table
    const tableBody = document.getElementById("applicantTableBody");
    function populateTable(applicants) {
      tableBody.innerHTML = "";
      applicants.forEach((applicant) => {
        const row = document.createElement("tr");
        row.innerHTML = `
                  <td class="p-3 border">${applicant.name}</td>
                  <td class="p-3 border">${applicant.applicantId}</td>
                  <td class="p-3 border">${applicant.school}</td>
                  <td class="p-3 border">${applicant.program}</td>
                  <td class="p-3 border">${applicant.dateApplied}</td>
                  <td class="p-3 border">${applicant.status}</td>
                    <td class="p-4 border-b">
                  <button class="text-blue-500 view-applicant" data-applicantId=${applicant.applicantId}>View</button>
                  
              </td>
              `;
        tableBody.appendChild(row);
      });
    }
    populateTable(data);

    // Update Filter Values
    function updateFilterValues() {
      const filterBy = document.getElementById("filterBy").value;
      const filterValue = document.getElementById("filterValue");
      filterValue.innerHTML = `<option value="">Select value</option>`;

      // Get unique values for the selected filter
      if (filterBy) {
        const uniqueValues = [
          ...new Set(data.map((applicant) => applicant[filterBy])),
        ];
        uniqueValues.forEach((value) => {
          const option = document.createElement("option");
          option.value = value;
          option.textContent = value;
          filterValue.appendChild(option);
        });
      }
    }

    // Search Functionality
    document.getElementById("search").addEventListener("input", function () {
      const searchValue = this.value.toLowerCase();
      const filteredData = data.filter(
        (applicant) =>
          applicant.name.toLowerCase().includes(searchValue) ||
          applicant.applicantId.toLowerCase().includes(searchValue)
      );
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

    document.querySelectorAll("th[data-column]").forEach((link) => {
      link.addEventListener("click", function (event) {
        const column = this.getAttribute("data-column");
        sortTable(column);
      });
    });

    // Add a listener to add the filter values upon selection of the filter category
    document.getElementById("filterBy").addEventListener("change", function () {
      updateFilterValues();
    });

    // Filter Functionality
    document.getElementById("applyFilter").addEventListener("click", function () {
      const filterBy = document.getElementById("filterBy").value;
      const filterValue = document.getElementById("filterValue").value;
      const filteredData =
        filterBy && filterValue
          ? data.filter((applicant) => applicant[filterBy] === filterValue)
          : data;
      populateTable(filteredData);
    });

    //listener for view applicant page
document.querySelectorAll(".view-applicant").forEach((element) => {
  element.addEventListener("click", function () {
    const applicantId = this.getAttribute("data-applicantId");
    viewApplicant(applicantId);
  });
});
  
// function to be run when the view of an applicant is clicked
  function viewApplicant(applicantId) {
    fetch(`./pages/view-applicant.html?id=${applicantId}`)
      .then((response) => response.text())
      .then((applicantInfo) => {
        const mainContent = document.getElementById("main-content");
        mainContent.innerHTML = applicantInfo;
        console.log(`Loaded applicant with ID: ${applicantId}`);
      })
      .catch((error) => {
        console.error('Error fetching applicant data:', error);
      });
  }   
}

// function to show update modal for student application
function toggleUpdateModal(show) {
  document.getElementById('updateModal').classList.toggle('hidden', !show);
} 

// Load the selected page and inject the content into the main-content area
function loadPage(page) {
  fetch(`./pages/${page}`)
    .then((response) => response.text())
    .then((html) => {
      const mainContent = document.getElementById("main-content");
      mainContent.innerHTML = html;
      console.log(page);

      // Call the respective function based on the loaded page
      switch (page) {
        case "dashboard.html":
          loadAdminDashboard();
          break;
        case "applicants.html":
          loadApplicants();
              break;
        case "payments.html":
          loadPayments();
          break;
        case "profile.html":
          loadProfile();
          break;
        case "notices.html":
          loadNoticesPage();
          break;
        default:
          console.error("No matching function for the page:", page);
      }
    })
        .catch((error) => console.error("Error loading page:", error));
    
    if (page != 'view-applicant.html') {
        localStorage.setItem('activePage', page);
    }
}
