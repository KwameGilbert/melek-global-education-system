

// Funtion to toogle Application Status Modal
function toggleApplicationStatusModal(show) {
    document.getElementById('applicationStatusModal').classList.toggle('hidden', !show);
}

// Function to update application status
async function updateApplicationStatus(event) {
    event.preventDefault();

    // Get button elements
    const btnText = document.querySelector('#updateStatusBtn span');
    const btnSpinner = document.querySelector('#updateStatusSpinner');

    // Show loading state
    btnText.textContent = 'Saving';
    btnSpinner.classList.remove('hidden');

    setTimeout(() => { }, 2000);
    // Get the application ID and status from the form
    const applicationId = document.getElementById('application_id').innerText;
    const applicationStatus = document.querySelector('select[name="application_status"]').value;

    console.log("Application ID: ", applicationId)
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
                showConfirmButton: false,
                timer: 2000
            });

            // Close the modal
            viewApplicant(applicationId);

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
        })
    } finally {
        // Reset button state
        btnText.textContent = 'Save';
        btnSpinner.classList.add('hidden');
        toggleApplicationStatusModal(false);
    }
}

// Function to show/hide add update form
function toggleAddUpdateModal(show) {
    document.getElementById('addUpdateModal').classList.toggle('hidden', !show);
}

// Function to show/hide edit update form
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

// 
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
function addUpdate(event) {
    event.preventDefault();

    // Get button elements
    const btnText = document.querySelector('#addUpdateBtn span');
    const btnSpinner = document.querySelector('#addUpdateSpinner');

    // Show loading state
    btnText.textContent = 'Saving';
    btnSpinner.classList.remove('hidden');

    const applicationId = document.getElementById('application_id').innerText;
    const title = document.getElementById('addUpdateTitle').value;
    const dateTime = document.getElementById('addUpdateDateTime').value;
    const message = document.getElementById('addUpdateMessage').value;

    fetch('../../../api/update/addUpdate.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            application_id: applicationId,
            title: title,
            date_time: dateTime,
            message: message
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                Swal.fire({
                    title: 'Success!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Reset form and close modal
                    document.getElementById('addUpdateForm').reset();

                    // Refresh the applicant view
                    viewApplicant(applicationId);
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: data.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error("Error adding update:", error);
            Swal.fire({
                title: 'Error!',
                text: 'An unexpected error occurred while adding the update.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }).finally(() => {
            // Reset button state
            btnText.textContent = 'Save';
            btnSpinner.classList.add('hidden');
            toggleAddUpdateModal(false);
        });
}

// Function to edit an update
function editUpdate(event) {
    event.preventDefault();

    // Get button elements
    const btnText = document.querySelector('#editUpdateBtn span');
    const btnSpinner = document.querySelector('#editUpdateSpinner');

    // Show loading state
    btnText.textContent = 'Saving';
    btnSpinner.classList.remove('hidden');

    const updateId = document.getElementById('editUpdateId').value;
    const title = document.getElementById('editUpdateTitle').value;
    const dateTime = document.getElementById('editUpdateDate').value;
    const message = document.getElementById('editUpdateMessage').value;

    setTimeout(() => { }, 2000);

    fetch('../../../api/update/editUpdate.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            update_id: updateId,
            title: title,
            date_time: dateTime,
            message: message
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                Swal.fire({
                    title: 'Success!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Reset form and close modal
                    document.getElementById('editUpdateForm').reset();
                    toggleEditUpdateModal(false);
                    // Refresh the applicant view
                    viewApplicant(document.getElementById('application_id').innerText);
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: data.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error("Error editing update:", error);
            Swal.fire({
                title: 'Error!',
                text: 'An unexpected error occurred while editing the update.',
                icon: 'error',
                confirmButtonText: 'OK'
            })
                .finally(() => {
                    // Reset button state
                    btnText.textContent = 'Save';
                    btnSpinner.classList.add('hidden');
                });
        });
}

// Function to delete an update
function deleteUpdate(updateId) {
    fetch('../../../api/update/deleteUpdate.php', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            update_id: updateId
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                Swal.fire({
                    title: 'Success!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    viewApplicant(document.getElementById('application_id').innerText);
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: data.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error("Error deleting update:", error);
            Swal.fire({
                title: 'Error!',
                text: 'An unexpected error occurred while deleting the update.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
}

function saveForm() {
    // Get the element
    const element = document.getElementById('application_details');

    // Get applicant name for the filename
    const applicantName = document.getElementById('applicant_name').innerText || 'application';
    const filename = `${applicantName.replace(/\s+/g, '_')}_form.pdf`;

    // Configure html2pdf options
    const opt = {
        margin: 1,
        filename: filename,
        image: { type: 'jpeg', quality: 1.00 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
    };

    // Add loading state to button
    const btn = document.querySelector('[onclick="saveForm()"]');
    const originalText = btn.innerText;
    btn.innerHTML = `
        <span class="inline-block">Downloading...</span>
        <svg class="w-4 h-4 ml-2 inline-block animate-spin" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>`;
    btn.disabled = true;

    // Generate PDF
    html2pdf().set(opt).from(element).save()
        .then(() => {
            // Reset button state
            btn.innerHTML = originalText;
            btn.disabled = false;
        })
        .catch(error => {
            console.error('Error generating PDF:', error);
            Swal.fire({
                title: 'Error!',
                text: 'Failed to generate PDF. Please try again.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
}


