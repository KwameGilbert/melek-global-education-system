function toggleAddUpdateModal(show) {
    document.getElementById('addUpdateModal').classList.toggle('hidden', !show);
}

function toggleEditUpdateModal(show, button = null) {
    // Toggle the visibility of the edit modal
    document.getElementById('editUpdateModal').classList.toggle('hidden', !show);

    if (show && button) {
        // Ensure the modal elements are present before setting values
        const updateIdField = document.getElementById('editUpdateId');
        const titleField = document.getElementById('editUpdateTitle');
        const dateField = document.getElementById('editUpdateDate');
        const messageField = document.getElementById('editUpdateMessage');

        if (updateIdField && titleField && dateField && messageField) {
            // Access data attributes from the button element
            const updateId = button.getAttribute('data-id');
            const title = button.getAttribute('data-title');
            const date = button.getAttribute('data-date');
            const message = button.getAttribute('data-message');

            // Populate modal fields with the retrieved data
            updateIdField.value = updateId;
            titleField.value = title;
            dateField.value = date;
            messageField.value = message;
        }
    }
}

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

// Function to add an update


// Function to edit an update
// Function to update application status
async function updateApplicationStatus(event) {
    event.preventDefault();

    // Get the application ID and status from the form
    const applicationId = document.getElementById('application_id').innerText;
    const applicationStatus = document.querySelector('input[name="application_status"]').value;

    console.log("Application ID: ",applicationId)
    try {
        // Make a fetch call to updateApplicationStatus.php
        const response = await fetch('../../../api/applicants/updateApplicationStatus.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                application_id: applicationId,
                application_status: applicationStatus
            })
        });

        const data = await response.json();
   
        if (data.status) {
            // Show success message
            Swal.fire({
                title: 'Success!',
                text: data.message,
                icon: 'success',
                confirmButtonText: 'OK'
            });

            // Close the modal

            toggleApplicationStatusModal(false);

          //  viewApplicant(applicantId);
            
        } else {
            // Show error message
            Swal.fire({
                title: 'Error!',
                text: data.message,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    } catch (error) {
        console.error('Error updating application status:', error);
        Swal.fire({
            title: 'Error!',
            text: 'An unexpected error occurred. Please try again.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }
}

// Function to delete an update
function deleteUpdate(updateId) {
    // Send a delete request to the server
    fetch(`deleteUpdate.php?id=${updateId}`, {
        method: 'POST', // Adjust this method as per your server requirement
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Update deleted successfully.");
                // Refresh or re-render the updates list here
                loadUpdates(); // Assuming you have a function to reload the updates
            } else {
                alert("Failed to delete the update.");
            }
        })
        .catch(error => {
            console.error("Error deleting update:", error);
            alert("An error occurred while deleting the update.");
        });
}


// Funtion to toogle Application Status Modal
function toggleApplicationStatusModal(show) {
    document.getElementById('applicationStatusModal').classList.toggle('hidden', !show);
}
