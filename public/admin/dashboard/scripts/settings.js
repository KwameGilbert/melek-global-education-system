// Global state management
const state = {
    editMode: false,
    userData: null
};

// Initialize the page
function initializeSettingsPage() {
    // Set initial active tab
    // switchTab('profile');
    setupEventListeners();
    loadUserData();

    // Handle browser back/forward buttons
    // window.addEventListener('popstate', (event) => {
    //     if (event.state?.page) {
    //         switchTab(event.state.page);
    //     }
    // });
}

// Setup all event listeners
function setupEventListeners() {
    // File upload handling
    const fileInput = document.querySelector('input[type="file"]');
    fileInput?.addEventListener('change', handleProfilePhotoUpload);

    // Edit button handling
    const editButton = document.querySelector('button[type="button"]');
    editButton?.addEventListener('click', () => toggleEditMode());

    // Form submission
    const form = document.querySelector('form');
    form?.addEventListener('submit', handleFormSubmit);
}

// Handle profile photo upload
function handleProfilePhotoUpload(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const profileImage = document.querySelector('img[alt="Profile"]');
            profileImage.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}

// Toggle edit mode
function toggleEditMode() {
    state.editMode = !state.editMode;
    const inputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="tel"], select');
    const editButton = document.querySelector('button[type="button"]');
    const saveButton = document.querySelector('button[type="submit"]');

    inputs.forEach(input => {
        input.readOnly = !state.editMode;
        if (input.tagName === 'SELECT') {
            input.disabled = !state.editMode;
        }
    });

    if (state.editMode) {
        editButton.classList.replace('bg-yellow-500', 'bg-gray-500');
        editButton.classList.replace('hover:bg-yellow-600', 'hover:bg-gray-600');
        saveButton.classList.remove('hidden');
    } else {
        editButton.classList.replace('bg-gray-500', 'bg-yellow-500');
        editButton.classList.replace('hover:bg-gray-600', 'hover:bg-yellow-600');
        saveButton.classList.add('hidden');
    }
}

// Handle form submission
async function handleFormSubmit(event) {
    event.preventDefault();
    
    // Collect form data
    const formData = new FormData(event.target);
    const data = Object.fromEntries(formData.entries());

    // Validate required fields
    const requiredFields = ['firstName', 'lastName', 'email', 'contact', 'gender', 'role'];
    const missingFields = requiredFields.filter(field => !data[field]);
    
    if (missingFields.length > 0) {
        showToast(`Please fill in all required fields: ${missingFields.join(', ')}`, 'error');
        return;
    }

    // Validate email format
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(data.email)) {
        showToast('Please enter a valid email address', 'error');
        return;
    }

    // Validate phone number (international format)
    if (!/^\+\d{1,4}\s?\d{6,14}$/.test(data.contact)) {
        showToast('Please enter a valid international phone number (e.g., +1 1234567890)', 'error');
        return;
    }
    
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
        title: 'Saving changes...',
        timer: 2000,
        timerProgressBar: true
    });

    try {
        const response = await fetch('../../../api/admin/updateAdmin.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const result = await response.json();

        if (!result.status) {
            throw new Error(result.message || 'Unknown error occurred');
        }

        showToast('Settings updated successfully', 'success');
        toggleEditMode();
        
        await loadUserData();
    } catch (error) {
        console.error('Error updating settings:', error);
        showToast(`Failed to update settings: ${error.message}`, 'error');
    } finally {
        loadingToast.close();
    }
}

// Load user data
async function loadUserData() {
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
        title: 'Loading your settings...',
        timer: 2000,
        timerProgressBar: true
    });

    try {
        const response = await fetch('../../../api/admin/adminData.php');
        const result = await response.json();

        if (!result.status) {
            throw new Error(result.message);
        }

        // Populate form fields
        const userData = result.data;
        Object.entries(userData).forEach(([key, value]) => {
            const input = document.querySelector(`[name="${key}"]`);
            if (input) {
                if (key === 'profilePhoto' && value) {
                    document.querySelector('img[alt="Profile"]').src = value;
                } else {
                    input.value = value;
                }
            }
        });

        state.userData = userData;
    } catch (error) {
        console.error('Error loading user data:', error);
        showToast('Failed to load user data: ' + error.message, 'error');
    }
}

// Show toast messages
function showToast(message, icon = 'success') {
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: icon,
        title: message,
        showConfirmButton: false,
        timer: 3000
    });
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    setupEventListeners();
    loadUserData();
});
