// Global state to store data
let globalData = {
    countries: [],
    schools: [],
    programs: []
};

// Fetch all data from server
function fetchAllData() {
    fetch('../../../api/school/allSchools.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                globalData = data;
                renderAllLists();
                populateDropdowns();
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong while fetching data!',
            });
        });
}

// Render functions for each list
function renderCountryList() {
    const list = document.getElementById('countryList');
    list.innerHTML = globalData.countries.map(country => `
    <li class="py-4 flex justify-between items-center">
      <span id="country-${country.id}">${country.name}</span>
      <div class="space-x-2">
        <button onclick="editCountry(${country.id})" class="text-blue-600 hover:text-blue-800">
          <i class="fas fa-edit"></i>
        </button>
        <button onclick="deleteCountry(${country.id})" class="text-red-600 hover:text-red-800">
          <i class="fas fa-trash"></i>
        </button>
      </div>
    </li>
  `).join('');
}

function renderSchoolList() {
    const list = document.getElementById('schoolList');
    list.innerHTML = globalData.schools.map(school => {
        const country = globalData.countries.find(c => c.id === school.country_id);
        return `
      <li class="py-4 flex justify-between items-center">
        <div>
          <span id="school-${school.id}">${school.name}</span>
          <span class="text-sm text-gray-500"> - ${school.city}, ${country?.name || 'Unknown'}</span>
        </div>
        <div class="space-x-2">
          <button onclick="editSchool(${school.id})" class="text-blue-600 hover:text-blue-800">
            <i class="fas fa-edit"></i>
          </button>
          <button onclick="deleteSchool(${school.id})" class="text-red-600 hover:text-red-800">
            <i class="fas fa-trash"></i>
          </button>
        </div>
      </li>
    `;
    }).join('');
}

function renderProgramList() {
    const list = document.getElementById('programList');
    list.innerHTML = globalData.programs.map(program => {
        const school = globalData.schools.find(s => s.id === program.school_id);
        return `
      <li class="py-4 flex justify-between items-center">
        <div>
          <span id="program-${program.id}">${program.degree} ${program.name}</span>
          <span class="text-sm text-gray-500"> - ${school?.name || 'Unknown'}</span>
        </div>
        <div class="space-x-2">
          <button onclick="editProgram(${program.id})" class="text-blue-600 hover:text-blue-800">
            <i class="fas fa-edit"></i>
          </button>
          <button onclick="deleteProgram(${program.id})" class="text-red-600 hover:text-red-800">
            <i class="fas fa-trash"></i>
          </button>
        </div>
      </li>
    `;
    }).join('');
}

function renderAllLists() {
    renderCountryList();
    renderSchoolList();
    renderProgramList();
}

// Populate dropdowns
function populateDropdowns() {
    // Populate country dropdown
    const countrySelect = document.getElementById('selectCountry');
    countrySelect.innerHTML = '<option value="">Select Country</option>' +
        globalData.countries.map(country =>
            `<option value="${country.id}">${country.name}</option>`
        ).join('');

    // Populate school dropdown
    const schoolSelect = document.getElementById('selectSchool');
    schoolSelect.innerHTML = '<option value="">Select School</option>' +
        globalData.schools.map(school =>
            `<option value="${school.id}">${school.name}</option>`
        ).join('');
}

// Add functions
function addCountry() {
    const nameInput = document.getElementById('countryName');
    const name = nameInput.value.trim();
    if (!name) return;

    fetch('../../../api/country/addCountry.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ name })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message
                });
                fetchAllData();
                nameInput.value = '';
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: data.message
                });
            }
        })
        .catch(error => console.error('Error adding country:', error));
}

function addSchool() {
    const nameInput = document.getElementById('schoolName');
    const cityInput = document.getElementById('schoolCity');
    const countrySelect = document.getElementById('selectCountry');

    const name = nameInput.value.trim();
    const city = cityInput.value.trim();
    const country_id = countrySelect.value;

    if (!name || !city || !country_id) {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Please fill in all fields'
        });
        return;
    }

    fetch('../../../api/school/addSchool.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ name, city, country_id })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message
                });
                fetchAllData();
                nameInput.value = '';
                cityInput.value = '';
                countrySelect.value = '';
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: data.message
                });
            }
        })
        .catch(error => {
            console.error('Error adding school:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Failed to add school. Please try again.'
            });
        });
}

function addProgram() {
    const nameInput = document.getElementById('programName');
    const degree = document.getElementById('degreeType');
    const schoolSelect = document.getElementById('selectSchool');

    const name = nameInput.value.trim();
    const degreeType = degree.value;
    const school_id = schoolSelect.value;

    if (!name || !degreeType || !school_id) {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Please fill in all fields'
        });
        return;
    }

    fetch('../../../api/program/addProgram.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ name, degreeType, school_id })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message
                });
                fetchAllData();
                nameInput.value = '';
                degree.value = '';
                schoolSelect.value = '';
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: data.message
                });
            }
        })
        .catch(error => {
            console.error('Error adding program:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Failed to add program. Please try again.'
            });
        });
}

// Edit functions
function editCountry(id) {
    const country = globalData.countries.find(c => c.id === id);

    Swal.fire({
        title: 'Edit Country',
        input: 'text',
        inputValue: country.name,
        inputLabel: 'Country Name',
        showCancelButton: true,
        confirmButtonText: 'Update',
        cancelButtonText: 'Cancel',
        inputValidator: (value) => {
            if (!value || value.trim() === '') {
                return 'Country name cannot be empty!';
            }
            if (value === country.name) {
                return 'Please enter a different name!';
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('../../../api/country/updateCountry.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id, name: result.value })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: data.message
                        });
                        fetchAllData();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.message
                        });
                    }
                })
                .catch(error => {
                    console.error('Error updating country:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to update country. Please try again.'
                    });
                });
        }
    });
}

function editSchool(id) {
    const school = globalData.schools.find(s => s.id === id);

    Swal.fire({
        title: 'Edit School',
        html: `
            <input id="swal-school-name" class="swal2-input" placeholder="School Name" value="${school.name}">
            <input id="swal-school-city" class="swal2-input" placeholder="City" value="${school.city}">
        `,
        showCancelButton: true,
        confirmButtonText: 'Update',
        cancelButtonText: 'Cancel',
        preConfirm: () => {
            const newName = document.getElementById('swal-school-name').value;
            const newCity = document.getElementById('swal-school-city').value;
            if (!newName || !newCity) {
                Swal.showValidationMessage('Please fill in all fields');
                return false;
            }
            if (newName === school.name && newCity === school.city) {
                Swal.showValidationMessage('Please make changes before updating');
                return false;
            }
            return { newName, newCity };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('../../../api/school/updateSchool.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    id,
                    name: result.value.newName,
                    city: result.value.newCity
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: data.message
                        });
                        fetchAllData();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.message
                        });
                    }
                })
                .catch(error => {
                    console.error('Error updating school:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to update school. Please try again.'
                    });
                });
        }
    });
}

function editProgram(id) {
    const program = globalData.programs.find(p => p.id === id);

    Swal.fire({
        title: 'Edit Program',
        html: `
            <input id="swal-program-name" class="swal2-input" placeholder="Program Name" value="${program.name}">
            <select id="swal-program-degree" class="swal2-input" style="border: 1px solid #d9d9d9;">
                <option value="BSc" ${program.degree === 'BSc' ? 'selected' : ''}>BSc</option>
                <option value="MSc" ${program.degree === 'MSc' ? 'selected' : ''}>MSc</option>
                <option value="PhD" ${program.degree === 'PhD' ? 'selected' : ''}>PhD</option>
            </select>
        `,
        showCancelButton: true,
        confirmButtonText: 'Update',
        cancelButtonText: 'Cancel',
        preConfirm: () => {
            const newName = document.getElementById('swal-program-name').value;
            const newDegree = document.getElementById('swal-program-degree').value;
            if (!newName) {
                Swal.showValidationMessage('Please fill in all fields');
                return false;
            }
            if (newName === program.name && newDegree === program.degree) {
                Swal.showValidationMessage('Please make changes before updating');
                return false;
            }
            return { newName, newDegree };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('../../../api/program/updateProgram.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    id,
                    name: result.value.newName,
                    degreeType: result.value.newDegree
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: data.message
                        });
                        fetchAllData();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.message
                        });
                    }
                })
                .catch(error => {
                    console.error('Error updating program:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to update program. Please try again.'
                    });
                });
        }
    });
}

// Delete functions
function deleteCountry(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('../../../api/country/deleteCountry.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire(
                            'Deleted!',
                            data.message,
                            'success'
                        );
                        fetchAllData();
                    } else {
                        Swal.fire(
                            'Error!',
                            data.message,
                            'error'
                        );
                    }
                })
                .catch(error => {
                    console.error('Error deleting country:', error);
                    Swal.fire(
                        'Error!',
                        'Failed to delete country. Please try again.',
                        'error'
                    );
                });
        }
    });
}

function deleteSchool(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('../../../api/school/deleteSchool.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire(
                            'Deleted!',
                            data.message,
                            'success'
                        );
                        fetchAllData();
                    } else {
                        Swal.fire(
                            'Error!',
                            data.message,
                            'error'
                        );
                    }
                })
                .catch(error => {
                    console.error('Error deleting school:', error);
                    Swal.fire(
                        'Error!',
                        'Failed to delete school. Please try again.',
                        'error'
                    );
                });
        }
    });
}

function deleteProgram(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('../../../api/program/deleteProgram.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire(
                            'Deleted!',
                            data.message,
                            'success'
                        );
                        fetchAllData();
                    } else {
                        Swal.fire(
                            'Error!',
                            data.message,
                            'error'
                        );
                    }
                })
                .catch(error => {
                    console.error('Error deleting program:', error);
                    Swal.fire(
                        'Error!',
                        'Failed to delete program. Please try again.',
                        'error'
                    );
                });
        }
    });
}

function initializeSchoolsPage() {

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
    title: 'Loading your Schools and Programs...',
    timer: 2000,
    timerProgressBar: true
});

    // Initial data load
    fetchAllData();
}