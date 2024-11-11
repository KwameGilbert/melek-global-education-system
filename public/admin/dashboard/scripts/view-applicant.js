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

const countrySelect = document.getElementById("country");
const schoolSelect = document.getElementById("school");
const degreeSelect = document.getElementById("degree");
const programSelect = document.getElementById("program");
const studyDurationInput = document.getElementById("study-duration");

let data = {};

// Fetch data from JSON file
fetch('../../../api/majorInfo/majorInfo.json')
    .then(response => response.json())
    .then(jsonData => {
        data = jsonData;
        populateCountries(data.countries);
    })
    .catch(error => console.error("Error fetching data:", error));

// Populate countries
function populateCountries(countries) {
    countrySelect.innerHTML = '<option value="">Select Country</option>';
    countries.forEach(country => {
        const option = new Option(country.country_name, country.id);
        countrySelect.add(option);
    });
}

// Country selection changes
countrySelect.addEventListener("change", () => {
    const selectedCountryId = countrySelect.value;
    const filteredSchools = data.schools.filter(school => school.country_id === selectedCountryId);
    populateSchools(filteredSchools);
    resetSelections(["school", "degree", "program"]);
});

// Populate schools
function populateSchools(schools) {
    schoolSelect.innerHTML = '<option value="">Select School</option>';
    schools.forEach(school => {
        const option = new Option(school.school_name, school.id);
        schoolSelect.add(option);
    });
}

// School selection changes
schoolSelect.addEventListener("change", () => {
    const selectedSchoolId = schoolSelect.value;
    const filteredPrograms = data.programs.filter(program => program.school_id === selectedSchoolId);
    const uniqueDegrees = Array.from(new Set(filteredPrograms.map(program => program.degree)));
    populateDegrees(uniqueDegrees);
    resetSelections(["degree", "program"]);
});

// Populate degrees
function populateDegrees(degrees) {
    degreeSelect.innerHTML = '<option value="">Select Degree</option>';
    degrees.forEach(degree => {
        const option = new Option(degree, degree); // Using degree name as both value and display text
        degreeSelect.add(option);
    });
}

// Degree selection changes
degreeSelect.addEventListener("change", () => {
    const selectedSchoolId = schoolSelect.value;
    const selectedDegree = degreeSelect.value;
    const filteredPrograms = data.programs.filter(
        program => program.school_id === selectedSchoolId && program.degree === selectedDegree
    );
    populatePrograms(filteredPrograms);
});

// Populate programs and set study duration
function populatePrograms(programs) {
    programSelect.innerHTML = '<option value="">Select Program</option>';
    programs.forEach(program => {
        const option = new Option(program.program_name, program.id);
        programSelect.add(option);
    });
    studyDurationInput.value = "";
}

// Program selection changes
programSelect.addEventListener("change", () => {
    const selectedProgramId = programSelect.value;
    const selectedProgram = data.programs.find(p => p.id === selectedProgramId);
    studyDurationInput.value = selectedProgram ? selectedProgram.duration : "";
});

// Reset dependent dropdowns
function resetSelections(elements) {
    elements.forEach(id => {
        document.getElementById(id).innerHTML = `<option value="">Select ${id.charAt(0).toUpperCase() + id.slice(1)}</option>`;
    });
}