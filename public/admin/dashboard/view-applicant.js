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
