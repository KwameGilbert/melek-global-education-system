<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Melek Global - Services</title>
    <link rel="stylesheet" href='/../imports/tailwind/tailwind.min.css'>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <?php require_once __DIR__ . '/../components/nav.php'; ?>

    <!-- Hero Section -->
    <section class="bg-cover bg-center h-64" style="background-image: url('https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80');">
        <div class="bg-black bg-opacity-50 h-full flex items-center justify-center">
            <h1 class="text-white text-5xl font-bold">Services</h1>
        </div>
    </section>


    <!-- Main Content -->
    <main class="container mx-auto px-4 py-12 max-w-7xl">
        <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Our Services</h2>
        <!-- Services Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Study Abroad Card -->
            <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow p-6 border border-gray-100">
                <div class="flex items-center mb-4">
                    <i class="fas fa-graduation-cap text-2xl text-blue-600 mr-3"></i>
                    <h2 class="text-2xl font-bold text-gray-800">Study Abroad</h2>
                </div>
                <p class="text-gray-600 mb-4">
                    Expert guidance for international education, including:
                </p>
                <ul class="text-gray-600 space-y-2 mb-4">
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Admission assistance</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Documentation support</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Interview preparation</li>
                </ul>
            </div>

            <!-- Flight Booking Card -->
            <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow p-6 border border-gray-100">
                <div class="flex items-center mb-4">
                    <i class="fas fa-plane text-2xl text-blue-600 mr-3"></i>
                    <h2 class="text-2xl font-bold text-gray-800">Flight Booking</h2>
                </div>
                <p class="text-gray-600 mb-4">
                    Seamless travel planning with competitive rates, including:
                </p>
                <ul class="text-gray-600 space-y-2 mb-4">
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Best deal search</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Custom itineraries</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> 24/7 support</li>
                </ul>
            </div>

            <!-- Work Abroad Card -->
            <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow p-6 border border-gray-100">
                <div class="flex items-center mb-4">
                    <i class="fas fa-briefcase text-2xl text-blue-600 mr-3"></i>
                    <h2 class="text-2xl font-bold text-gray-800">Work Abroad</h2>
                </div>
                <p class="text-gray-600 mb-4">
                    Professional career guidance abroad, including:
                </p>
                <ul class="text-gray-600 space-y-2 mb-4">
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Job placements</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Visa processing</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Work permit support</li>
                </ul>
            </div>

            <!-- Accommodation Card -->
            <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow p-6 border border-gray-100">
                <div class="flex items-center mb-4">
                    <i class="fas fa-hotel text-2xl text-blue-600 mr-3"></i>
                    <h2 class="text-2xl font-bold text-gray-800">Accommodation</h2>
                </div>
                <p class="text-gray-600 mb-4">
                    Comprehensive housing solutions, including:
                </p>
                <ul class="text-gray-600 space-y-2 mb-4">
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Hotel bookings</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Student housing</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Long-term rentals</li>
                </ul>
            </div>

            <!-- Visa Assistance Card -->
            <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow p-6 border border-gray-100">
                <div class="flex items-center mb-4">
                    <i class="fas fa-passport text-2xl text-blue-600 mr-3"></i>
                    <h2 class="text-2xl font-bold text-gray-800">Visa Assistance</h2>
                </div>
                <p class="text-gray-600 mb-4">
                    Complete visa support services, including:
                </p>
                <ul class="text-gray-600 space-y-2 mb-4">
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Application guidance</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Document processing</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Permit assistance</li>
                </ul>
            </div>
        </div>
    </main>

    <?php require_once __DIR__ . '/../components/footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // Safe Feather Icons initialization
            if (typeof feather !== 'undefined') {
                feather.replace();
            } else {
                console.warn('Feather Icons library not loaded');
            }
        });

        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.toggle('hidden');
        }
    </script>
</body>

</html>