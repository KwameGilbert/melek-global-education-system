// Define function to show the selected page section
function showPage(page) {
  // Hide all pages
  document.querySelectorAll('.profile-page, .security-page, .payment-page').forEach(page => {
    page.classList.add('hidden');
  });

  // Show the selected page
  if (page === 'profile') {
    document.getElementById('js-profile-page').classList.remove('hidden');
  } else if (page === 'security') {
    document.getElementById('js-security-page').classList.remove('hidden');
  } else if (page === 'payment') {
    document.getElementById('js-payment-page').classList.remove('hidden');
  }
}

// Toggle Edit Mode
function toggleEditMode(page, isEditing) {
  const elements = document.querySelectorAll(`#${page}-page input, #${page}-page select`);
  elements.forEach(el => {
    el.readOnly = !isEditing;
    el.disabled = !isEditing;
  });
}

// Save Changes
function saveChanges(page) {
  alert(`${page} changes saved!`);
  toggleEditMode(page, false); // Disable edit mode after saving
}
