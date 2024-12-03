function loadApplications() {
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
        title: 'Loading your application form...',
        timer: 3000,
        timerProgressBar: true
    });

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



    document.getElementById('add-work-entry').addEventListener('click', function (event) {
        event.preventDefault(); // Prevent form submission

        // Get the container where new entries will be added
        const container = document.getElementById('work-history-container');

        // Clone the first study entry
        const newEntry = document.querySelector('.work-entry').cloneNode(true);

        // Clear the values of all input fields in the cloned entry
        const inputs = newEntry.querySelectorAll('input');
        inputs.forEach(input => {
            input.value = ''; // Reset the input field value
        });

        // Append the cleared cloned entry to the container
        container.appendChild(newEntry);
    });
}

// Fetch schools by country
async function fetchSchools() {
    const countryId = document.getElementById('country').value;
    const schoolDropdown = document.getElementById('school');
    const degreeDropdown = document.getElementById('degree');
    const programDropdown = document.getElementById('program');
    const studyDuration = document.getElementById('study-duration');

    // Reset dependent fields
    schoolDropdown.innerHTML = '<option value="">Select a school</option>';
    degreeDropdown.innerHTML = '<option value="">Select a degree</option>';
    programDropdown.innerHTML = '<option value="">Select a program</option>';
    studyDuration.value = '';
    schoolDropdown.disabled = true;
    degreeDropdown.disabled = true;
    programDropdown.disabled = true;

    if (countryId) {
        const response = await fetch(`../../../api/application_form/fetch_schools.php?country_id=${countryId}`);
        const schools = await response.json();

        if (schools.length > 0) {
            schools.forEach((school) => {
                const option = document.createElement('option');
                option.value = school.school_id;
                option.textContent = school.school_name;
                schoolDropdown.appendChild(option);
            });
            schoolDropdown.disabled = false;
        }
    }
}

//Fetch Degrees By school
async function fetchDegrees() {
    const schoolId = document.getElementById('school').value;
    const degreeDropdown = document.getElementById('degree');
    const programDropdown = document.getElementById('program');
    const studyDuration = document.getElementById('study-duration');

    // Reset dependent fields
    degreeDropdown.innerHTML = '<option value="">Select a degree</option>';
    programDropdown.innerHTML = '<option value="">Select a program</option>';
    studyDuration.value = '';
    degreeDropdown.disabled = true;
    programDropdown.disabled = true;

    if (schoolId) {
        const response = await fetch(`../../../api/application_form/fetch_degrees.php?school_id=${schoolId}`);
        const degrees = await response.json();

        if (degrees.length > 0) {
            degrees.forEach((degree) => {
                const option = document.createElement('option');
                option.value = degree.degree_id;
                option.textContent = degree.degree_name;
                degreeDropdown.appendChild(option);
            });
            degreeDropdown.disabled = false;
        }
    }
}

// Fetch programes based on school
async function fetchPrograms() {
    const schoolId = document.getElementById('school').value;
    const degree = document.getElementById('degree').value;
    const programDropdown = document.getElementById('program');
    const studyDuration = document.getElementById('study-duration');

    // Reset dependent fields
    programDropdown.innerHTML = '<option value="">Select a program</option>';
    studyDuration.value = '';
    programDropdown.disabled = true;

    if (schoolId && degree) {
        const response = await fetch(`../../../api/application_form/fetch_programs.php?school_id=${schoolId}&degree=${degree}`);
        const programs = await response.json();

        if (programs.length > 0) {
            programs.forEach((program) => {
                const option = document.createElement('option');
                option.value = program.program_id;
                option.textContent = program.program_name;
                option.dataset.duration = program.program_duration; // Store duration
                programDropdown.appendChild(option);
            });
            programDropdown.disabled = false;
        }
    }
}

// Show program duration
function showDuration() {
    const programDropdown = document.getElementById('program');
    const studyDuration = document.getElementById('study-duration');
    const selectedOption = programDropdown.options[programDropdown.selectedIndex];

    if (selectedOption.dataset.duration) {
        studyDuration.value = `${selectedOption.dataset.duration} years`;
    } else {
        studyDuration.value = '';
    }
}


function saveApplication(event) {
    event.preventDefault();
    const form = document.getElementById('application-form');
    const formData = new FormData(form);
    const formDataObj = {};
    formData.forEach((value, key) => {
        formDataObj[key] = value;
    });

   // console.log(JSON.stringify(formDataObj));

    fetch('../../../api/application_form/save_application.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Application submitted successfully',
                    text: data.message
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Application submission failed',
                    text: data.message
                });
            }
        })

}

async function handleFileUpload(event) {
    const input = event.target;
    const file = input.files[0];

    const toastMixin = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });

    if (!file) {
        toastMixin.fire({
            icon: 'warning',
            title: 'Warning',
            text: 'No file selected for upload.',
        });
        return;
    }

    // Show progress notification
    let progressAlert = Swal.fire({
        title: 'Uploading...',
        text: `Uploading ${input.name}. Please wait.`,
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        },
    });

    // Create form data to send to the server
    const formData = new FormData();
    formData.append(input.name, file); // Use the input's `name` as the key

    try {
        const response = await fetch('../../../api/student/documents/upload.php', {
            method: 'POST',
            body: formData, // FormData automatically sets the correct headers
        });

        const data = await response.json();

        Swal.close(); // Close the loading alert

        if (data.success) {
            toastMixin.fire({
                icon: 'success',
                title: 'Success',
                text: `${input.name} uploaded successfully!`,
            });
        } else {
            toastMixin.fire({
                icon: 'error',
                title: 'Upload Failed',
                text: data.message || `An error occurred while uploading ${input.name}.`,
            });
        }
    } catch (error) {
        Swal.close(); // Close the loading alert

        toastMixin.fire({
            icon: 'error',
            title: 'Error',
            text: `An unexpected error occurred: ${error.message}`,
        });
    }
}



// //0246814884