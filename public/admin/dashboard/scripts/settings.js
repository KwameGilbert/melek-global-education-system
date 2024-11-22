// Global state management
const state = {
    activeTab: 'profile',
    editMode: {
        profile: false,
        payment: false
    },
    otpEnabled: false
};

// Initialize the page
function initializeSettingsPage() {
    // Set initial active tab
    switchTab('profile');
    setupEventListeners();
    loadUserData();

    // Handle browser back/forward buttons
    window.addEventListener('popstate', (event) => {
        if (event.state?.page) {
            switchTab(event.state.page);
        }
    });
}

// Setup all event listeners
function setupEventListeners() {
    // Mobile menu handling
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    mobileMenuButton?.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
        // Toggle icon between bars and times
        const icon = mobileMenuButton.querySelector('i');
        icon.classList.toggle('fa-bars');
        icon.classList.toggle('fa-times');
    });

    // Window resize handler
    window.addEventListener('resize', debounce(() => {
        if (window.innerWidth >= 768) {
            mobileMenu?.classList.add('hidden');
            mobileMenuButton?.querySelector('i').classList.replace('fa-times', 'fa-bars');
        }
    }, 250));

    // File upload preview
    const fileInput = document.querySelector('.choose-file');
    fileInput?.addEventListener('change', handleProfilePhotoUpload);

    // Form submissions
    setupFormSubmissions();
}

// Handle profile photo upload
function handleProfilePhotoUpload(event) {
    const file = event.target.files[0];
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = (e) => {
            document.querySelector('.profile-photo img').src = e.target.result;
            showToast('Profile photo updated successfully', 'success');
        };
        reader.readAsDataURL(file);
    } else {
        showToast('Please select a valid image file', 'error');
    }
}

// Setup form submissions
function setupFormSubmissions() {
    // Profile form
    const profileForm = document.querySelector('#profile-page form');
    profileForm?.addEventListener('submit', (e) => {
        e.preventDefault();
        saveChanges('profile');
    });

    // Security form
    const securityForm = document.querySelector('#security-page form');
    securityForm?.addEventListener('submit', (e) => {
        e.preventDefault();
        handlePasswordChange();
    });

    // Payment form
    const paymentForm = document.querySelector('#payment-page form');
    paymentForm?.addEventListener('submit', (e) => {
        e.preventDefault();
        saveChanges('payment');
    });
}

// Switch between tabs
function switchTab(page) {
    state.activeTab = page;

    // Update URL without page reload
    history.pushState({ page }, '', `#${page}`);

    // Hide all pages and show selected
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
        content.classList.remove('animate-fadeIn');
    });

    const selectedPage = document.getElementById(`${page}-page`);
    if (selectedPage) {
        selectedPage.classList.remove('hidden');
        // Trigger animation
        setTimeout(() => selectedPage.classList.add('animate-fadeIn'), 0);
    }

    updateTabStyles();
    closeMobileMenu();
}

// Update tab styles
function updateTabStyles() {
    document.querySelectorAll('.tab-item').forEach(tab => {
        const isActive = tab.id === `${state.activeTab}-tab`;
        tab.classList.toggle('bg-white', isActive);
        tab.classList.toggle('text-gray-700', isActive);
        tab.classList.toggle('text-white', !isActive);

        // Update icon colors
        const icon = tab.querySelector('i');
        if (icon) {
            icon.classList.toggle('text-gray-700', isActive);
            icon.classList.toggle('text-white', !isActive);
        }
    });
}

// Toggle edit mode
function toggleEditMode(page, isEditing) {
    state.editMode[page] = isEditing;

    const pageElement = document.getElementById(`${page}-page`);
    const inputs = pageElement.querySelectorAll('input:not([type="file"]), select');
    const editButton = pageElement.querySelector('.edit-button');
    const saveButton = pageElement.querySelector('.save-button');

    inputs.forEach(input => {
        input.readOnly = !isEditing;
        input.disabled = !isEditing;
        if (isEditing) {
            input.classList.add('border-green-500', 'focus:ring-2', 'focus:ring-green-200');
        } else {
            input.classList.remove('border-green-500', 'focus:ring-2', 'focus:ring-green-200');
        }
    });

    // Toggle button visibility with animation
    editButton.classList.toggle('hidden', isEditing);
    saveButton.classList.toggle('hidden', !isEditing);
}

// Save changes
async function saveChanges(page) {
    try {
        const pageElement = document.getElementById(`${page}-page`);
        const formData = new FormData(pageElement.querySelector('form'));

        // Show loading state
        Swal.fire({
            title: 'Saving changes...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Simulate API call
        await new Promise(resolve => setTimeout(resolve, 1000));

        // Success feedback
        Swal.fire({
            icon: 'success',
            title: 'Changes Saved!',
            text: `Your ${page} settings have been updated successfully.`,
            timer: 2000,
            showConfirmButton: false
        });

        toggleEditMode(page, false);
    } catch (error) {
        console.error('Error saving changes:', error);
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong! Please try again.'
        });
    }
}

// Handle password change
async function handlePasswordChange() {
    const currentPassword = document.getElementById('current-password').value;
    const newPassword = document.getElementById('new-password').value;
    const confirmPassword = document.getElementById('confirm-password').value;

    if (newPassword !== confirmPassword) {
        showToast('New passwords do not match', 'error');
        return;
    }

    try {
        // Show loading state
        Swal.fire({
            title: 'Changing password...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Simulate API call
        await new Promise(resolve => setTimeout(resolve, 1000));

        // Success feedback
        Swal.fire({
            icon: 'success',
            title: 'Password Changed!',
            text: 'Your password has been updated successfully.',
            timer: 2000,
            showConfirmButton: false
        });

        // Clear form
        document.getElementById('security-page').querySelector('form').reset();
    } catch (error) {
        console.error('Error changing password:', error);
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Failed to change password. Please try again.'
        });
    }
}

// Toggle OTP Request
function toggleOTPRequest(checkbox) {
    state.otpEnabled = checkbox.checked;

    const lockIcon = document.querySelector('.toggle-lock');
    const unlockIcon = document.querySelector('.toggle-unlock');
    const toggleIcon = document.querySelector('.toggle-icon');
    const checkBtn = document.querySelector('.check-btn');

    // Add smooth transitions
    [toggleIcon, checkBtn].forEach(el => {
        el.style.transition = 'all 0.3s ease-in-out';
    });

    if (state.otpEnabled) {
        lockIcon.classList.add('hidden');
        unlockIcon.classList.remove('hidden');
        toggleIcon.style.transform = 'translateX(24px)';
        checkBtn.classList.replace('bg-gray-300', 'bg-green-500');
        showToast('2FA has been enabled', 'success');
    } else {
        lockIcon.classList.remove('hidden');
        unlockIcon.classList.add('hidden');
        toggleIcon.style.transform = 'translateX(0)';
        checkBtn.classList.replace('bg-green-500', 'bg-gray-300');
        showToast('2FA has been disabled', 'warning');
    }
}

// Utility Functions
function showToast(message, icon = 'success') {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });

    Toast.fire({
        icon,
        title: message
    });
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function closeMobileMenu() {
    const mobileMenu = document.getElementById('mobile-menu');
    const menuButton = document.getElementById('mobile-menu-button');
    if (mobileMenu && menuButton) {
        mobileMenu.classList.add('hidden');
        menuButton.querySelector('i').classList.replace('fa-times', 'fa-bars');
    }
}

// Load user data (simulate API call)
async function loadUserData() {
    try {
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
            title: 'Loading your settings...',
            timer: 1000,
            timerProgressBar: true
        });

        // Simulate API call
        await new Promise(resolve => setTimeout(resolve, 1000));

        // Update UI with loaded data
        // ... (implement as needed based on your API response structure)
    } catch (error) {
        console.error('Error loading user data:', error);
        showToast('Failed to load user data', 'error');
    }
}

// Initialize when DOM is loaded
//document.addEventListener('DOMContentLoaded', initializeSettingsPage);

