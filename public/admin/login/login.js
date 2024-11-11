// Add this in your HTML head


document.getElementById('login-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    try {
        const response = await fetch('../../../api/login/login.php', {
            method: 'POST',
            body: new FormData(e.target)
        });
        
        const data = await response.json();
        
        if (data.status) {
            // Show success message
            Swal.fire({
                title: 'Login Successfully!',
                text: data.message,
                icon: data.icon,
                timer: 2000,
                showConfirmButton: false,
                allowOutsideClick: false,
                didClose: () => {
                    window.location.href = data.redirect;
                }
            });
        } else {
            // Show error message
            Swal.fire({
                title: 'Error!',
                text: data.message,
                icon: data.icon,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Try Again'
            });
        }
    } catch (error) {
        console.log(error);
        Swal.fire({
            title: 'Error!',
            text: `An unexpected error occurred. Please try again.`,
            icon: 'error',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
    }
});