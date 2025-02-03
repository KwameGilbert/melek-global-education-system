function initiatePayment() {
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
        title: 'Loading your Payments...',
        timer: 3000,
        timerProgressBar: true
    });
}

 // Function to process Paystack payment
function processPaystackPayment() {
    const studentEmail = document.querySelector('#studentEmail').innerText;
    const applicationCost = parseFloat((document.querySelector('#applicationCost').innerText).replace(/,/g, ''));

        const handler = PaystackPop.setup({
            key: 'pk_test_f0fd646f16ebd917af6bc8fb4ea2cdcb9b3b99c5', // Replace with your Paystack public key
            email: studentEmail, // Replace with user's email address
            amount: applicationCost * 100, // Replace with the amount in kobo (100.00 * 100 = 10000)
            currency: 'GHS', // Specify currency (e.g., USD, GHS, NGN, etc.)
            callback: function (response) {
                if (response.status === 'success') {
                    // Redirect to a success page
                    recordPayment(response.reference, response.status);
                }
            },
            onClose: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Payment Canceled',
                    text: 'Your payment has been canceled',
                });
            }
        });

        handler.openIframe(); // Open the Paystack payment modal
}

function recordPayment(reference, paymentStatus) {
    // Record Payment for user

    const studentEmail = document.querySelector('#studentEmail').innerText;
    const applicationCost = parseFloat((document.querySelector('#applicationCost').innerText).replace(/,/g, ''));
    const applicationId = document.querySelector('#application_id').innerText;

    fetch('../../../api/student/payment/pay.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            reference,
            paymentStatus,
            studentEmail,
            applicationCost,
            applicationId
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Payment Successful',
                    text: 'Your payment has been recorded successfully!',
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Payment Failed',
                    text: data.message || 'An error occurred while processing your payment.',
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Something went wrong. Please try again.',
            });
        });
}
