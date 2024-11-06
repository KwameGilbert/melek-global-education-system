// Function to add a country
function addCountry() {
    const countryName = document.getElementById('countryName').value;
    if (!countryName) return;

    // Simulate POST request to backend
    fetch('/api/countries', {
        method: 'POST',
        body: JSON.stringify({ name: countryName }),
        headers: { 'Content-Type': 'application/json' }
    }).then(response => response.json()).then(data => {
        if (data.success) {
            document.getElementById('countryList').innerHTML += `
                <li class="flex justify-between bg-white p-4 rounded shadow">
                    <span>${countryName}</span>
                    <button onclick="deleteCountry(${data.id})" class="text-red-500">Delete</button>
                </li>
            `;
            document.getElementById('countryForm').reset();
            loadCountries();
        }
    });
}

// Function to load countries into dropdowns and list
function loadCountries() {
    fetch('./api/countries.json').then(response => response.json()).then(data => {
        const countryList = document.getElementById('countryList');
        const selectCountry = document.getElementById('selectCountry');
        countryList.innerHTML = '';
        selectCountry.innerHTML = '<option value="">Select Country</option>';

        data.forEach(entry => {
            entry.country.forEach(country => {
                console.log(country.id +" "+country.name)
                countryList.innerHTML += `
                <li class="flex justify-between bg-white p-4 rounded shadow">
                    <span>${country.name}</span>
                    <button onclick="deleteCountry(${country.id})" class="text-red-500">Delete</button>
                </li>
            `;
                selectCountry.innerHTML += `<option value="${country.id}">${country.name}</option>`;
            });
        });
    });
}

// Function to add a school
function addSchool() {
    const countryId = document.getElementById('selectCountry').value;
    const schoolName = document.getElementById('schoolName').value;
    const schoolCity = document.getElementById('schoolCity').value;

    fetch('/api/schools', {
        method: 'POST',
        body: JSON.stringify({ countryId, name: schoolName, city: schoolCity }),
        headers: { 'Content-Type': 'application/json' }
    }).then(response => response.json()).then(data => {
        if (data.success) {
            document.getElementById('schoolList').innerHTML += `
                <li class="flex justify-between bg-white p-4 rounded shadow">
                    <span>${schoolName}, ${schoolCity}</span>
                    <button onclick="deleteSchool(${data.id})" class="text-red-500">Delete</button>
                </li>
            `;
            document.getElementById('schoolForm').reset();
            loadSchools();
        }
    });
}

// Function to load schools into dropdown
function loadSchools() {
    fetch('./api/schools.json').then(response => response.json()).then(data => {
        const selectSchool = document.getElementById('selectSchool');
        selectSchool.innerHTML = '<option value="">Select School</option>';

        data.forEach(entry => {
            entry.school.forEach(school => {
                console.log(school.name);
                selectSchool.innerHTML += `<option value="${school.id}">${school.name} - ${school.city}</option>`;
            });
        });
    });
}

// Function to add a program
function addProgram() {
    const schoolId = document.getElementById('selectSchool').value;
    const programName = document.getElementById('programName').value;

    fetch('/api/programs', {
        method: 'POST',
        body: JSON.stringify({ schoolId, name: programName }),
        headers: { 'Content-Type': 'application/json' }
    }).then(response => response.json()).then(data => {
        if (data.success) {
            document.getElementById('programList').innerHTML += `
                <li class="flex justify-between bg-white p-4 rounded shadow">
                    <span>${programName}</span>
                    <button onclick="deleteProgram(${data.id})" class="text-red-500">Delete</button>
                </li>
            `;
            document.getElementById('programForm').reset();
        }
    });
}

function initializeSchoolsPage() {
    loadCountries();
    loadSchools();
}

