document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.innerHTML;
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Show loading spinner
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Processing...
        `;
        
        // Get form values
        const firstname = document.getElementById('firstname').value.trim();
        const lastname = document.getElementById('lastname').value.trim();
        const gender = document.getElementById('gender').value.trim();
        const nationality = document.getElementById('nationality').value.trim();
        const dob = document.getElementById('dob').value.trim();
        const contact = document.getElementById('contact').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm-password').value;
        
        // Basic validation
        const requiredFields = {
            'First Name': firstname,
            'Last Name': lastname,
            'Gender': gender,
            'Nationality': nationality,
            'Date of Birth': dob,
            'Contact Number': contact,
            'Email': email,
            'Password': password,
            'Confirm Password': confirmPassword
        };

        // Check for empty fields
        const emptyFields = Object.entries(requiredFields)
            .filter(([_, value]) => !value)
            .map(([key]) => key);

        if (emptyFields.length > 0) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
            Swal.fire({
                title: 'Error!',
                text: `Please fill in the following fields: ${emptyFields.join(', ')}`,
                icon: 'error'
            });
            return;
        }

        // Email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
            Swal.fire({
                title: 'Error!',
                text: 'Please enter a valid email address',
                icon: 'error'
            });
            return;
        }
        
        // Password validation
        if (password !== confirmPassword) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
            Swal.fire({
                title: 'Error!',
                text: 'Passwords do not match',
                icon: 'error'
            });
            return;
        }

        // Password strength validation
        if (password.length < 8) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
            Swal.fire({
                title: 'Error!',
                text: 'Password must be at least 8 characters long',
                icon: 'error'
            });
            return;
        }
        
        // Create FormData object
        const formData = new FormData();
        formData.append('firstname', firstname);
        formData.append('lastname', lastname);
        formData.append('gender', gender);
        formData.append('nationality', nationality);
        formData.append('dob', dob);
        formData.append('contact', contact);
        formData.append('email', email);
        formData.append('password', password);
        
        try {
            const response = await fetch('../../../api/student/createStudent.php', {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            // Reset button state
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
            
            if (data.status) {
                // Success message with auto-close
                Swal.fire({
                    title: 'Success!',
                    text: data.message,
                    icon: 'success',
                    timer: 3000,
                    showConfirmButton: false
                }).then(() => {
                    // Redirect to login page
                    window.location.href = '../login/';
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: data.message,
                    icon: 'error'
                });
            }
            
        } catch (error) {
            // Reset button state
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
            
            Swal.fire({
                title: 'Error!',
                text: 'An error occurred. Please try again later.',
                icon: 'error'
            });
        }
    });

    // Add real-time password match validation
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm-password');
    const inputs = [passwordInput, confirmPasswordInput];

    inputs.forEach(input => {
        input.addEventListener('input', () => {
            if (confirmPasswordInput.value) {
                if (passwordInput.value !== confirmPasswordInput.value) {
                    confirmPasswordInput.classList.add('border-red-500');
                    confirmPasswordInput.classList.remove('border-green-500');
                } else {
                    confirmPasswordInput.classList.remove('border-red-500');
                    confirmPasswordInput.classList.add('border-green-500');
                }
            }
        });
    });
});
