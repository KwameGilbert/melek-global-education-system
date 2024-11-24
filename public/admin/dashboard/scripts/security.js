// Security page state management
const securityState = {
    isEditMode: false
};

// Handle security form submission
async function handleSecuritySubmit(event) {
    event.preventDefault();
    
    try {
        const currentPassword = document.getElementById('currentPassword').value;
        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        // Validate inputs
        if (!currentPassword || !newPassword || !confirmPassword) {
            throw new Error('All password fields are required');
        }

        if (newPassword !== confirmPassword) {
            throw new Error('New passwords do not match');
        }

        showLoadingToast('Updating password...');

        const response = await fetch('../../../api/admin/adminSecurity.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                action: 'updatePassword',
                currentPassword,
                newPassword,
                confirmPassword
            })
        });

        const result = await response.json();
        if (!result.status) {
            throw new Error(result.message);
        }

        showToast('Password updated successfully', 'success');
        toggleSecurityEditMode(); // Exit edit mode
        return true;
    } catch (error) {
        showToast(error.message, 'error');
        return false;
    }
}

// Toggle security form edit mode
function toggleSecurityEditMode() {
    const form = document.getElementById('securityForm');
    const inputs = form.querySelectorAll('input[type="password"]');
    const submitBtn = form.querySelector('button[type="submit"]');
    const editBtn = document.getElementById('toggleSecurityEdit');

    securityState.isEditMode = !securityState.isEditMode;

    // Update button text and icon
    editBtn.innerHTML = securityState.isEditMode ? 
        '<i class="fas fa-times mr-2"></i>Cancel' : 
        '<i class="fas fa-edit mr-2"></i>Edit';

    editBtn.classList.toggle('bg-yellow-500');
    editBtn.classList.toggle('hover:bg-yellow-600');
    editBtn.classList.toggle('bg-gray-500');
    editBtn.classList.toggle('hover:bg-gray-600');

    // Update form fields
    inputs.forEach(input => {
        input.readOnly = !securityState.isEditMode;
        input.value = '';
        input.classList.toggle('bg-gray-50');
        input.classList.toggle('bg-white');
    });

    // Toggle submit button
    submitBtn.classList.toggle('hidden');
}

// Setup password visibility toggles
function setupPasswordToggles() {
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.onclick = function(e) {
            e.preventDefault();
            const input = this.parentElement.querySelector('input');
            const icon = this.querySelector('i');
            
            // Toggle password visibility
            input.type = input.type === 'password' ? 'text' : 'password';
            
            // Toggle icon
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        };
    });
}

// Initialize security features
function initializeSecurity() {
    // Setup form submission
    const securityForm = document.getElementById('securityForm');
    if (securityForm) {
        securityForm.onsubmit = handleSecuritySubmit;
    }

    // Setup edit mode toggle
    const toggleSecurityEdit = document.getElementById('toggleSecurityEdit');
    if (toggleSecurityEdit) {
        toggleSecurityEdit.onclick = toggleSecurityEditMode;
    }

    // Setup password visibility toggles
    setupPasswordToggles();
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', initializeSecurity);
