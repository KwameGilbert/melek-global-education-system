function loadApplications() {
    document.getElementById('add-study-entry').addEventListener('click', function (event) {
        event.preventDefault(); // Prevent form submission

        // Get the container where new entries will be added
        const container = document.getElementById('study-experience-container');

        // Clone the first study entry
        const newEntry = document.querySelector('.study-entry').cloneNode(true);

        // Clear the values of all input fields in the cloned entry
        const inputs = newEntry.querySelectorAll('input');
        inputs.forEach(input => {
            input.value = ''; // Reset the input field value
        });

        // Append the cleared cloned entry to the container
        container.appendChild(newEntry);
    });
}

// //0246814884