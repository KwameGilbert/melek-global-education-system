// Add event listeners to all sidebar links
document.querySelectorAll("a[data-page]").forEach((link) => {
  link.addEventListener("click", function (event) {
    event.preventDefault();
    const page = this.getAttribute("data-page"); // Fetch the data-page value
    // Save the selected page in localStorage
    localStorage.setItem("activePage", page);
    loadPage(page); // Call the loadPage function
  });

  function loadAdminDashboard() {
    console.log("Admin Dashboard Loaded");
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
      title: 'Loading your Admin Dashboard...',
      timer: 2000,
      timerProgressBar: true
    });

    // Fetch data from dashboard.php for the chart and summary
    fetch("../../../api/dashboard/dashboardData.php")
      .then((response) => response.json())
      .then((data) => {
        if (data.status) {
          // Update the chart with data from dashboard.php
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
                  data: [
                    data.metric.totalApplicants,
                    data.metric.totalAdmitted,
                    data.metric.totalProcessing,
                    data.metric.totalRejected,
                    data.metric.pendingPayment,
                    data.metric.pendingProcessing,
                  ],
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

          // Update summary section values
          document.getElementById("totalApplicants").textContent = data.metric.totalApplicants;
          document.getElementById("totalAdmitted").textContent = data.metric.totalAdmitted;
          document.getElementById("totalProcessing").textContent = data.metric.totalProcessing;
          document.getElementById("totalRejected").textContent = data.metric.totalRejected;
          document.getElementById("pendingPayment").textContent = data.metric.pendingPayment;
          document.getElementById("pendingProcessing").textContent = data.metric.pendingProcessing;
        } else {
          console.error("Error:", data.message);
        }
      })
      .catch((error) => {
        console.error("Error fetching dashboard data:", error);
      });
  }

  // Start Applicant Category
  async function loadApplicants() {
    console.log("Applicants loaded successfully");

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
      title: 'Loading applicants data...',
      timer: 2000,
      timerProgressBar: true
    });


    let applicants = []; // Define applicants globally within this function
    let sortOrder = true; // Define sortOrder globally for consistent sorting

    try {
      // Fetch data from allApplicants.php
      const response = await fetch("../../../api/applicants/allApplicants.php");
      const data = await response.json();

      if (data.status) {
        applicants = data.applicants; // Save applicants globally

        // Populate Table with initial data
        populateTable(applicants);
      } else {
        console.error("Error: ", data.message);
      }
    } catch (error) {
      console.error("Error fetching applicants data:", error);
    }

    // Populate Table function
    function populateTable(applicantsData) {
      const tableBody = document.getElementById("applicantTableBody");
      tableBody.innerHTML = "";
      applicantsData.forEach((applicant) => {
        const row = document.createElement("tr");
        row.innerHTML = `
        <td class="p-3 border">${applicant.name}</td>
        <td class="p-3 border">${applicant.applicantId}</td>
        <td class="p-3 border">${applicant.school}</td>
        <td class="p-3 border">${applicant.program}</td>
        <td class="p-3 border">${applicant.dateApplied}</td>
        <td class="p-3 border">${applicant.status}</td>
        <td class="p-4 border-b">
          <button class="text-blue-500 view-applicant" data-applicantId="${applicant.applicantId}">View</button>
        </td>
      `;
        tableBody.appendChild(row);
      });

      // Add event listeners for view buttons
      document.querySelectorAll(".view-applicant").forEach((button) => {
        button.addEventListener("click", (e) => {
          const applicantId = e.target.getAttribute("data-applicantId");
          console.log(`View applicant with ID: ${applicantId}`);
          viewApplicant(applicantId);
        });
      });
    }

    // Update Filter Values
    function updateFilterValues() {
      const filterBy = document.getElementById("filterBy").value;
      const filterValue = document.getElementById("filterValue");
      filterValue.innerHTML = `<option value="">Select value</option>`;

      if (filterBy) {
        const uniqueValues = [
          ...new Set(applicants.map((applicant) => applicant[filterBy])),
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
      const filteredData = applicants.filter(
        (applicant) =>
          applicant.name.toLowerCase().includes(searchValue) ||
          applicant.applicantId.toLowerCase().includes(searchValue)
      );
      populateTable(filteredData);
    });

    // Sort Table
    function sortTable(column) {
      const sortedData = [...applicants].sort((a, b) => {
        if (a[column] < b[column]) return sortOrder ? -1 : 1;
        if (a[column] > b[column]) return sortOrder ? 1 : -1;
        return 0;
      });
      sortOrder = !sortOrder; // Toggle the sort order
      populateTable(sortedData);
    }

    document.querySelectorAll("th[data-column]").forEach((link) => {
      link.addEventListener("click", function () {
        const column = this.getAttribute("data-column");
        sortTable(column);
      });
    });

    // Add a listener to update filter values upon selection of the filter category
    document.getElementById("filterBy").addEventListener("change", function () {
      updateFilterValues();
    });

    // Filter Functionality
    document.getElementById("applyFilter").addEventListener("click", function () {
      const filterBy = document.getElementById("filterBy").value;
      const filterValue = document.getElementById("filterValue").value;
      const filteredData =
        filterBy && filterValue
          ? applicants.filter((applicant) => applicant[filterBy] === filterValue)
          : applicants;
      populateTable(filteredData);
    });
  }


  // Function to be run when the view of an applicant is clicked
  function viewApplicant(applicantId) {
    console.log("Loading applicant:", applicantId);
    fetch(`./pages/view-applicant.php?id=${applicantId}`)
      .then((response) => response.text())
      .then((applicantInfo) => {
        const mainContent = document.getElementById("main-content");
        mainContent.innerHTML = applicantInfo;
        console.log(`Loaded applicant with ID: ${applicantId}`);

      })
      .catch((error) => {
        console.error("Error fetching applicant data:", error);
      });
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
          case "schools.html":
            initializeSchoolsPage();
            break;
          case "profile.html":
            loadProfile();
            break;
          case "notices.html":
            loadNoticesPage();
            break;
          case "settings.html":
            initializeSettingsPage();
            initializeSecurity();
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

});