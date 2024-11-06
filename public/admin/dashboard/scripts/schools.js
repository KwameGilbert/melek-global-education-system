// State management
const appState = {
    countries: [],
    schools: [],
    programs: [],
};

// Utility functions
const generateId = () => crypto.randomUUID();

const createElement = (item, type) => {
    const li = document.createElement('li');
    li.className = 'py-4 flex items-center justify-between gap-4';

    const mainContent = document.createElement('div');
    mainContent.className = 'flex-1 min-w-0';

    const details = document.createElement('div');
    details.className = 'flex flex-col sm:flex-row sm:items-center gap-2';

    switch (type) {
        case 'country':
            details.innerHTML = `
                <span class="text-sm font-medium text-gray-900">${item.name}</span>
                <span class="text-sm text-gray-500">${item.schools?.length || 0} schools</span>
            `;
            break;
        case 'school':
            details.innerHTML = `
                <span class="text-sm font-medium text-gray-900">${item.name}</span>
                <span class="text-sm text-gray-500">${item.city}</span>
                <span class="text-sm text-gray-500">${item.programs?.length || 0} programs</span>
            `;
            break;
        case 'program':
            details.innerHTML = `
                <span class="text-sm font-medium text-gray-900">${item.name}</span>
                <span class="text-sm text-gray-500">${item.schoolName}</span>
            `;
            break;
    }

    mainContent.appendChild(details);
    li.appendChild(mainContent);

    // Action buttons
    const actions = document.createElement('div');
    actions.className = 'flex items-center gap-2';

    const editBtn = document.createElement('button');
    editBtn.className = 'inline-flex items-center px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500';
    editBtn.textContent = 'Edit';
    editBtn.onclick = () => handleEdit(item.id, type);

    const deleteBtn = document.createElement('button');
    deleteBtn.className = 'inline-flex items-center px-3 py-1 border border-transparent rounded-md text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500';
    deleteBtn.textContent = 'Delete';
    deleteBtn.onclick = () => handleDelete(item.id, type);

    actions.appendChild(editBtn);
    actions.appendChild(deleteBtn);
    li.appendChild(actions);

    return li;
};

// Validation functions
const validateInput = (input, type) => {
    const errors = [];
    if (!input.trim()) {
        errors.push(`${type} name cannot be empty`);
    }
    if (input.length < 2) {
        errors.push(`${type} name must be at least 2 characters long`);
    }
    return errors;
};

// Toast notification
const showNotification = (message, type = 'success') => {
    const toast = document.createElement('div');
    toast.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg ${type === 'success' ? 'bg-green-500' : 'bg-red-500'
        } text-white`;
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
};

// Event Handlers
const handleEdit = async (id, type) => {
    try {
        let item;
        switch (type) {
            case 'country':
                item = appState.countries.find(c => c.id === id);
                break;
            case 'school':
                item = appState.schools.find(s => s.id === id);
                break;
            case 'program':
                item = appState.programs.find(p => p.id === id);
                break;
        }

        const newName = prompt(`Edit ${type} name:`, item.name);
        if (newName && newName.trim()) {
            const errors = validateInput(newName, type);
            if (errors.length) {
                throw new Error(errors.join('\n'));
            }

            item.name = newName.trim();
            updateUI();
            showNotification(`${type} updated successfully`);
        }
    } catch (error) {
        showNotification(error.message, 'error');
    }
};

const handleDelete = async (id, type) => {
    try {
        if (!confirm(`Are you sure you want to delete this ${type}?`)) {
            return;
        }

        switch (type) {
            case 'country':
                appState.countries = appState.countries.filter(c => c.id !== id);
                appState.schools = appState.schools.filter(s => s.countryId !== id);
                break;
            case 'school':
                appState.schools = appState.schools.filter(s => s.id !== id);
                appState.programs = appState.programs.filter(p => p.schoolId !== id);
                break;
            case 'program':
                appState.programs = appState.programs.filter(p => p.id !== id);
                break;
        }

        updateUI();
        showNotification(`${type} deleted successfully`);
    } catch (error) {
        showNotification(error.message, 'error');
    }
};

// Add functions
const addCountry = async () => {
    try {
        const input = document.getElementById('countryName');
        const name = input.value.trim();

        const errors = validateInput(name, 'Country');
        if (errors.length) {
            throw new Error(errors.join('\n'));
        }

        const country = {
            id: generateId(),
            name,
            schools: []
        };

        appState.countries.push(country);
        input.value = '';
        updateUI();
        showNotification('Country added successfully');
    } catch (error) {
        showNotification(error.message, 'error');
    }
};

const addSchool = async () => {
    try {
        const countrySelect = document.getElementById('selectCountry');
        const nameInput = document.getElementById('schoolName');
        const cityInput = document.getElementById('schoolCity');

        const countryId = countrySelect.value;
        const name = nameInput.value.trim();
        const city = cityInput.value.trim();

        if (!countryId) {
            throw new Error('Please select a country');
        }

        const errors = validateInput(name, 'School');
        errors.push(...validateInput(city, 'City'));
        if (errors.length) {
            throw new Error(errors.join('\n'));
        }

        const school = {
            id: generateId(),
            countryId,
            name,
            city,
            programs: []
        };

        appState.schools.push(school);
        nameInput.value = '';
        cityInput.value = '';
        updateUI();
        showNotification('School added successfully');
    } catch (error) {
        showNotification(error.message, 'error');
    }
};

const addProgram = async () => {
    try {
        const schoolSelect = document.getElementById('selectSchool');
        const nameInput = document.getElementById('programName');

        const schoolId = schoolSelect.value;
        const name = nameInput.value.trim();

        if (!schoolId) {
            throw new Error('Please select a school');
        }

        const errors = validateInput(name, 'Program');
        if (errors.length) {
            throw new Error(errors.join('\n'));
        }

        const school = appState.schools.find(s => s.id === schoolId);

        const program = {
            id: generateId(),
            schoolId,
            schoolName: school.name,
            name
        };

        appState.programs.push(program);
        nameInput.value = '';
        updateUI();
        showNotification('Program added successfully');
    } catch (error) {
        showNotification(error.message, 'error');
    }
};

// UI Update functions
const updateUI = () => {
    updateCountryList();
    updateSchoolList();
    updateProgramList();
    updateSelects();
};

const updateCountryList = () => {
    const list = document.getElementById('countryList');
    list.innerHTML = '';
    appState.countries.forEach(country => {
        list.appendChild(createElement(country, 'country'));
    });
};

const updateSchoolList = () => {
    const list = document.getElementById('schoolList');
    list.innerHTML = '';
    appState.schools.forEach(school => {
        list.appendChild(createElement(school, 'school'));
    });
};

const updateProgramList = () => {
    const list = document.getElementById('programList');
    list.innerHTML = '';
    appState.programs.forEach(program => {
        list.appendChild(createElement(program, 'program'));
    });
};

const updateSelects = () => {
    // Update country select
    const countrySelect = document.getElementById('selectCountry');
    countrySelect.innerHTML = '<option value="">Select Country</option>';
    appState.countries.forEach(country => {
        const option = document.createElement('option');
        option.value = country.id;
        option.textContent = country.name;
        countrySelect.appendChild(option);
    });

    // Update school select
    const schoolSelect = document.getElementById('selectSchool');
    schoolSelect.innerHTML = '<option value="">Select School</option>';
    appState.schools.forEach(school => {
        const option = document.createElement('option');
        option.value = school.id;
        option.textContent = `${school.name} (${school.city})`;
        schoolSelect.appendChild(option);
    });
};

// Initialize the application


function initializeSchoolsPage() {
    document.addEventListener('DOMContentLoaded', () => {
        updateUI();

        // Add event listeners for form submissions
        document.getElementById('countryForm').addEventListener('submit', (e) => {
            e.preventDefault();
            addCountry();
        });

        document.getElementById('schoolForm').addEventListener('submit', (e) => {
            e.preventDefault();
            addSchool();
        });

        document.getElementById('programForm').addEventListener('submit', (e) => {
            e.preventDefault();
            addProgram();
        });
    });
}
