// Define function to show the selected page section
function showPage(page) {
    // Hide all pages
    document.querySelectorAll('.profile-page, .security-page, .payment-page').forEach(page => {
        page.classList.add('hidden');
    });

    // Show the selected page
    if (page === 'profile') {
        document.getElementById('profile-page').classList.remove('hidden');
    } else if (page === 'security') {
        document.getElementById('security-page').classList.remove('hidden');
    } else if (page === 'payment') {
        document.getElementById('payment-page').classList.remove('hidden');
    }
}

// Toggle Edit Mode
function toggleEditMode(page, isEditing) {
    const elements = document.querySelectorAll(`#${page}-page input, #${page}-page select`);
    elements.forEach(el => {
        el.readOnly = !isEditing;
        el.disabled = !isEditing;
    });
};

// Save Changes
function saveChanges(page) {
    alert(`${page} changes saved!`);
    toggleEditMode(page, false); // Disable edit mode after saving
}

function toggleOTPRequest(checkbox) {
    const lockIcon = document.querySelector('.toggle-lock');
    const unlockIcon = document.querySelector('.toggle-unlock');

    if (checkbox.checked) {
        // Show the unlock icon and hide the lock icon when checked
        lockIcon.classList.add('hidden');
        unlockIcon.classList.remove('hidden');
        document.querySelector('.toggle-icon').style.transform = 'translateX(24px)';
    } else {
        // Show the lock icon and hide the unlock icon when unchecked
        lockIcon.classList.remove('hidden');
        unlockIcon.classList.add('hidden');
        document.querySelector('.toggle-icon').style.transform = 'translateX(0)';
    }
}