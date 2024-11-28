
async function updateProfile(e) {
    e.preventDefault();

    const formData = {
        name: document.getElementById('name').value,
        email: document.getElementById('email').value,
        contact: document.getElementById('contact').value,
        gender: document.getElementById('gender').value,
        dob: document.getElementById('dob').value,
        nationality: document.getElementById('nationality').value
    };

    try {
        const response = await fetch('../../../api/student/profile/updateProfile.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        });

        const data = await response.json();
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Profile updated successfully!'
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'Failed to update profile'
            });
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while updating profile'
        });
    }
}

async function changePassword(e) {
    e.preventDefault();

    const currentPassword = document.getElementById('current-password').value;
    const newPassword = document.getElementById('new-password').value;
    const confirmPassword = document.getElementById('confirm-password').value;

    if (newPassword !== confirmPassword) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'New passwords do not match!'
        });
        return;
    }

    try {
        const response = await fetch('../../../api/student/password/changePassword.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                currentPassword,
                newPassword
            })
        });

        const data = await response.json();
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Password changed successfully!'
            });
            document.getElementById('passwordForm').reset();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'Failed to change password'
            });
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while changing password'
        });
    }
}

function handleProfileImageUpload() {
    const input = document.getElementById('profile-image');

    input.addEventListener('change', async (e) => {
        const file = e.target.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('image', file);

        try {
            const response = await fetch('../../../api/student/profile/studentProfileImage.php', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.status === 'success') {
                // Update the image preview
                document.querySelectorAll('img[alt="User Avatar"]').forEach(img => {
                    img.src = data.image_url;
                });
                // Show success message
                alert('Profile image updated successfully!');
            } else {
                alert(data.message || 'Failed to update profile image');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Failed to upload image');
        }
    });
}

function initializeProfilePage() {

    handleProfileImageUpload();
}