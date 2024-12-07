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
                // Callback function to handle when the payment modal is closed
                alert('Payment process was cancelled.');
            }
        });

        handler.openIframe(); // Open the Paystack payment modal
}

function recordPayment(reference, paymentStatus) {
    // Record Payment for user
    
    const studentEmail = document.querySelector('#studentEmail').innerText;
    const applicationCost = parseFloat((document.querySelector('#applicationCost').innerText).replace(/,/g, ''));
    const applicationId = document.querySelector('#application_id').innerText;

    fetch('/student/dashboard/payment', {
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


}
    