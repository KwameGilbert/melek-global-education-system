// Global state to store data
let globalData = {
    countries: [],
    schools: [],
    programs: []
};

// Fetch all data from server
function fetchAllData() {
    fetch('./api/allSchools.json')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                globalData = data;
                renderAllLists();
                populateDropdowns();
            }
        })
        .catch(error => console.error('Error fetching data:', error));
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

    fetch('addCountry.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ name })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                fetchAllData();
                nameInput.value = '';
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

    if (!name || !city || !country_id) return;

    fetch('addSchool.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ name, city, country_id })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                fetchAllData();
                nameInput.value = '';
                cityInput.value = '';
                countrySelect.value = '';
            }
        })
        .catch(error => console.error('Error adding school:', error));
}

function addProgram() {
    const nameInput = document.getElementById('programName');
    const degree = document.getElementById('degreeType');
    const schoolSelect = document.getElementById('selectSchool');

    const name = nameInput.value.trim();
    const degreeType = degree.value;
    const school_id = schoolSelect.value;

    if (!name || !degreeType || !school_id) return;

    fetch('addProgram.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ name, degreeType, school_id })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                fetchAllData();
                nameInput.value = '';
                degree.value = '';
                schoolSelect.value = '';
            }
        })
        .catch(error => console.error('Error adding program:', error));
}

// Edit functions
function editCountry(id) {
    const country = globalData.countries.find(c => c.id === id);
    const newName = prompt('Enter new country name:', country.name);
    if (!newName || newName === country.name) return;

    fetch('updateCountry.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id, name: newName })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) fetchAllData();
        })
        .catch(error => console.error('Error updating country:', error));
}

function editSchool(id) {
    const school = globalData.schools.find(s => s.id === id);
    const newName = prompt('Enter new school name:', school.name);
    const newCity = prompt('Enter new city:', school.city);

    if (!newName || !newCity || (newName === school.name && newCity === school.city)) return;

    fetch('updateSchool.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id, name: newName, city: newCity })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) fetchAllData();
        })
        .catch(error => console.error('Error updating school:', error));
}

function editProgram(id) {
    const program = globalData.programs.find(p => p.id === id);
    const newName = prompt('Enter new program name:', program.name);
    if (!newName || newName === program.name) return;

    fetch('updateProgram.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id, name: newName })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) fetchAllData();
        })
        .catch(error => console.error('Error updating program:', error));
}

// Delete functions
function deleteCountry(id) {
    if (!confirm('Are you sure you want to delete this country?')) return;

    fetch('deleteCountry.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) fetchAllData();
        })
        .catch(error => console.error('Error deleting country:', error));
}

function deleteSchool(id) {
    if (!confirm('Are you sure you want to delete this school?')) return;

    fetch('deleteSchool.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) fetchAllData();
        })
        .catch(error => console.error('Error deleting school:', error));
}

function deleteProgram(id) {
    if (!confirm('Are you sure you want to delete this program?')) return;

    fetch('deleteProgram.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) fetchAllData();
        })
        .catch(error => console.error('Error deleting program:', error));
}

function initializeSchoolsPage() {
    // Initial data load
    fetchAllData();
}
