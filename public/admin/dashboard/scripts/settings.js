// Global state management
const state = {
    editMode: false,
    userData: null,
    currentTab: 'profile'
};

// Initialize the page
function initializeSettingsPage() {
    loadUserData();
    switchTab(state.currentTab);
    checkUrlForTab();
    
    // Setup basic event handlers
    document.querySelector('input[type="file"]').onchange = handleProfilePhotoUpload;
    document.querySelector('button[type="button"]').onclick = toggleEditMode;
    document.querySelector('form').onsubmit = handleFormSubmit;
    
    // Setup tab clicks
    document.querySelectorAll('.tab-link').forEach(link => {
        link.onclick = () => switchTab(link.getAttribute('data-tab'));
    });
    
    // Mobile menu toggle
    document.getElementById('mobile-menu-button').onclick = () => {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    };
}

// Switch between tabs
function switchTab(tabId) {
    // Update state
    state.currentTab = tabId;

    // Update URL without reload
    const url = new URL(window.location);
    url.searchParams.set('tab', tabId);
    window.history.pushState({}, '', url);

    // Update active tab styles
    document.querySelectorAll('.tab-link').forEach(link => {
        const isActive = link.getAttribute('data-tab') === tabId;
        link.classList.toggle('text-white', isActive);
        link.classList.toggle('text-gray-200', !isActive);
        if (link.closest('#mobile-menu')) {
            link.classList.toggle('bg-gray-600', isActive);
        }
    });

    // Show/hide content sections
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.toggle('hidden', content.id !== `${tabId}-page`);
    });

    // Close mobile menu after selection
    document.getElementById('mobile-menu')?.classList.add('hidden');
}

// Handle profile photo upload
async function handleProfilePhotoUpload(event) {
    const file = event.target.files[0];
    if (!file) return;

    // Show preview immediately
    const reader = new FileReader();
    reader.onload = (e) => {
        document.querySelectorAll('img[alt="Profile"]').forEach(img => {
            img.src = e.target.result;
        });
    };
    reader.readAsDataURL(file);

    // Upload the file
    try {
        const formData = new FormData();
        formData.append('image', file);
        
        showLoadingToast('Uploading image...');
        
        const response = await fetch('../../../api/admin/adminImage.php', {
            method: 'POST',
            body: formData
        });

        if (!response.ok) throw new Error('Failed to upload image');
        
        const result = await response.json();
        if (!result.status) throw new Error(result.message || 'Upload failed');

        // Refresh user data to get new image path
        await loadUserData();
        showToast('Profile photo updated successfully', 'success');
    } catch (error) {
        console.error('Error uploading image:', error);
        showToast('Failed to upload image: ' + error.message, 'error');
    }
}

// Toggle edit mode
function toggleEditMode() {
    state.editMode = !state.editMode;
    const inputs = document.querySelectorAll('input:not([type="file"]), select');
    const editButton = document.querySelector('button[type="button"]');
    const saveButton = document.querySelector('button[type="submit"]');

    inputs.forEach(input => {
        if (input.tagName === 'SELECT') {
            input.disabled = !state.editMode;
        } else {
            input.readOnly = !state.editMode;
        }
        input.classList.toggle('bg-gray-50', !state.editMode);
        input.classList.toggle('bg-white', state.editMode);
    });

    editButton.innerHTML = state.editMode ? 
        '<i class="fas fa-times mr-2"></i>Cancel' : 
        '<i class="fas fa-edit mr-2"></i>Edit';
    editButton.classList.toggle('bg-yellow-500', !state.editMode);
    editButton.classList.toggle('bg-gray-500', state.editMode);
    saveButton.classList.toggle('hidden', !state.editMode);
}

// Handle form submission
async function handleFormSubmit(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const data = Object.fromEntries(formData.entries());

    // Validate required fields
    const requiredFields = ['firstName', 'lastName', 'email', 'contact', 'gender', 'role'];
    const missingFields = requiredFields.filter(field => !data[field]);
    
    if (missingFields.length > 0) {
        showToast(`Please fill in all required fields: ${missingFields.join(', ')}`, 'error');
        return;
    }

    // Basic validation
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(data.email)) {
        showToast('Please enter a valid email address', 'error');
        return;
    }

    if (!/^\+\d{1,4}\s?\d{6,14}$/.test(data.contact)) {
        showToast('Please enter a valid international phone number (e.g., +1 1234567890)', 'error');
        return;
    }

    showLoadingToast('Saving changes...');

    try {
        const response = await fetch('../../../api/admin/updateAdmin.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });

        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
        const result = await response.json();
        if (!result.status) throw new Error(result.message || 'Update failed');

        showToast('Settings updated successfully', 'success');
        toggleEditMode();
        
        // Refresh data after successful update
        await loadUserData();
    } catch (error) {
        console.error('Error updating settings:', error);
        showToast(`Failed to update settings: ${error.message}`, 'error');
    }
}

// Load user data
async function loadUserData() {
    showLoadingToast('Loading your settings...');

    try {
        const response = await fetch('../../../api/admin/adminData.php');
        const result = await response.json();

        if (!result.status) throw new Error(result.message);

        const userData = result.data;
        
        // Update profile header
        document.querySelector('h2.text-3xl').textContent = 
            `${userData.firstName || ''} ${userData.lastName || ''}`;
        
        // Update role and location if elements exist
        const roleElement = document.querySelector('#adminRole');
        if (roleElement) roleElement.textContent = userData.role || '';
        
        const locationElement = document.querySelector('#adminLocation');
        if (locationElement) locationElement.textContent = userData.address || '';

        // Update profile images
        if (userData.profilePhoto) {
            document.querySelectorAll('img[alt="Profile"]').forEach(img => {
                img.src = userData.profilePhoto;
            });
        }else{
            document.querySelectorAll('img[alt="Profile"]').forEach(img => {
                img.src = './images/admin/default.png';
            });
        }

        // Fill all form inputs
        Object.entries(userData).forEach(([key, value]) => {
            const input = document.querySelector(`[name="${key}"]`);
            if (input) input.value = value || '';
        });

        state.userData = userData;
    } catch (error) {
        console.error('Error loading user data:', error);
        showToast('Failed to load user data: ' + error.message, 'error');
    }
}

// Toast utilities
function showLoadingToast(message) {
    return Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    }).fire({
        title: message,
        timer: 3000,
        timerProgressBar: true
    });
}

function showToast(message, icon = 'success') {
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon,
        title: message,
        showConfirmButton: false,
        timer: 3000
    });
}

// Check URL for initial tab
function checkUrlForTab() {
    const params = new URLSearchParams(window.location.search);
    const tabFromUrl = params.get('tab');
    if (tabFromUrl && ['profile', 'security', 'payment'].includes(tabFromUrl)) {
        state.currentTab = tabFromUrl;
    }
}

