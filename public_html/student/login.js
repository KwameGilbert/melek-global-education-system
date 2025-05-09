document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.querySelector('form');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const rememberBox = document.getElementById('remember');

    loginForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        // Basic validation
        if (!emailInput.value || !passwordInput.value) {
            Swal.fire({
                title: 'Error!',
                text: 'Please fill in all fields',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Email format validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(emailInput.value)) {
            Swal.fire({
                title: 'Error!',
                text: 'Please enter a valid email address',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        try {
            // Show loading state
            const submitButton = loginForm.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.innerHTML;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Logging in...';
            submitButton.disabled = true;

            // Make API call to login endpoint
            const response = await fetch('../api/student/login.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    email: emailInput.value,
                    password: passwordInput.value,
                    remember: rememberBox.value
                })
            });

            const data = await response.json();

            if (data.status === 'success') {
                // Success message
                Swal.fire({
                    title: 'Success!',
                    text: data.message,
                    icon: 'success',
                    timer: 3000,
                    showConfirmButton: false
                }).then(() => {
                    // Redirect to dashboard
                    window.location.href = './dashboard/';
                });
            } else {
                // Error message from API
                Swal.fire({
                    title: 'Login Failed',
                    text: data.message || 'An error occurred during login',
                    icon: 'error',
                    confirmButtonText: 'Try Again'
                });
            }
        } catch (error) {
            console.error('Login error:', error);
            Swal.fire({
                title: 'Error!',
                text: error,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        } finally {
            // Reset button state
            const submitButton = loginForm.querySelector('button[type="submit"]');
            submitButton.innerHTML = '<i class="fas fa-sign-in-alt mr-2"></i>Access Portal';
            submitButton.disabled = false;
        }
    });

    // Add input animations
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            input.parentElement.classList.add('scale-[1.02]');
        });
        input.addEventListener('blur', () => {
            input.parentElement.classList.remove('scale-[1.02]');
        });
    });
});
