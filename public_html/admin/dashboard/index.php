<?php
require_once '../../config/database.php';

// Start PHP session
session_start();

// Check if the user is logged in by verifying session variables
if (isset($_SESSION['admin_id'])) {
} else {
    // Redirect to login if session is not set
    header('Location: ../');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Melek Global Education</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.tailwindcss.com" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.6.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href='/imports/tailwind/tailwind.min.css'>



    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #3b82f6;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #2563eb;
        }
    </style>
</head>

<body class="h-screen overflow-hidden flex bg-gray-50">
    <!-- Sidebar -->
    <div id="sidebar" class="bg-gray-800 text-white w-64 space-y-6 py-7 px-2 absolute inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition duration-500 ease-in-out overflow-y-auto z-50">


        <!-- Close Button for Small Screens -->
        <div class="md:hidden flex justify-end pr-4">
            <button class="text-gray-400 hover:text-white focus:outline-none" onclick="toggleSidebar()">
                <i class="fas fa-times h-6 w-6"></i>
            </button>
        </div>

        <!-- Profile Section -->
        <div class="flex flex-col items-center mb-6">
            <img src="<?php echo $_SESSION['picture']; ?>" alt="Profile"
                class="w-24 h-24 rounded-full object-cover mb-2">
            <h2 class="text-lg font-semibold" id="adminName"><?php echo $_SESSION['admin_name']; ?></h2>
            <p class="text-sm text-gray-400" id="adminEmail"><?php echo $_SESSION['email']; ?></p>
        </div>

        <!-- Navigation -->
        <nav class="space-y-2">
            <a href="#" data-page="dashboard.html" class="flex items-center py-2.5 px-4 hover:bg-gray-700">
                <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
            </a>
            <a href="#" data-page="applicants.html" class="flex items-center py-2.5 px-4 hover:bg-gray-700">
                <i class="fas fa-users mr-3"></i> Applicants
            </a>
            <a href="#" data-page="schools.html" class="flex items-center py-2.5 px-4 hover:bg-gray-700">
                <i class="fas fa-school mr-3"></i> Manage Schools & Programs
            </a>
            <a href="#" data-page="settings.html" class="flex items-center py-2.5 px-4 hover:bg-gray-700">
                <i class="fas fa-cogs mr-3"></i> Settings
            </a>
            <a href="#" onclick="logout()"
                class="flex items-center py-2.5 px-4 hover:bg-red-600">
                <i class="fas fa-sign-out-alt mr-3"></i> Logout
            </a>
        </nav>
    </div>


    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col md:relative md:z-10 bg-white overflow-y-auto h-full">
        <!-- Header -->
        <header id="header" class="shadow w-full flex items-center justify-between p-4 bg-gray-50">
            <!-- Hamburger Icon and Title -->
            <div class="flex items-center">
                <button class="md:hidden text-gray-800 focus:outline-none" onclick="toggleSidebar()">
                    <i class="fas fa-bars h-6 w-6"></i>
                </button>
                <h1 class="text-xl text-gray-900 ml-4">Melek Global Education</h1>
            </div>

            <!-- Welcome and Logout Button -->
            <div class="flex items-center">
                <span class="text-gray-700 mr-4">Welcome, <?php echo $_SESSION['firstname']; ?></span>
                <button class="bg-blue-500 text-white py-1 px-4 rounded hover:bg-blue-600" onclick="logout()">Logout</button>
            </div>

        </header>

        <!-- Main Content -->
        <main id="main-content" class="flex-1 overflow-y-auto px-0 bg-white shadow-lg">
            <!-- Dynamic content will be loaded here -->
            <div id="page-content">
                <!-- Content will load dynamically -->
                <p class="text-center text-gray-500">Select a section from the sidebar to get started.</p>
            </div>
        </main>
    </div>

    <script src="./scripts/index.js"></script>
    <script src="./scripts/schools.js"></script>
    <script src="./scripts/settings.js"></script>
    <script src="./scripts/security.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="./scripts/view-applicant.js"></script>
    <script>
        // Toggle sidebar visibility
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full');
            document.body.classList.toggle('overflow-hidden');

            if (!sidebar.classList.contains('-translate-x-full')) {
                document.addEventListener('click', handleOutsideClick);
            } else {
                document.removeEventListener('click', handleOutsideClick);
            }
        }

        function handleOutsideClick(event) {
            const sidebar = document.getElementById('sidebar');
            if (!sidebar.contains(event.target) && !event.target.closest('.fa-bars')) {
                toggleSidebar();
            }
        }

        // On page load, check localStorage and load the appropriate page
        document.addEventListener('DOMContentLoaded', function() {
            const activePage = localStorage.getItem('activePage') || 'dashboard.html';
            loadPage(activePage);
        });

        async function logout() {
            try {
                const response = await fetch('../../../api/logout/logout.php', {
                    method: 'GET'
                });

                if (response.ok) {
                    // Redirect to login page
                    Swal.fire({
                        title: "Success",
                        text: "Logout successful",
                        icon: "success",
                        showConfirmButton: false,
                        allowOutsideClick: false,
                    })
                    window.location.href = '../';
                } else {
                    // Show error message
                    Swal.fire({
                        title: "Error!",
                        text: "Failed to log out. Please try again.",
                        icon: "error",
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "OK"
                    });
                }
            } catch (error) {
                console.log(error);
                Swal.fire({
                    title: "Error!",
                    text: "An unexpected error occurred. Please try again.",
                    icon: "error",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "OK"
                });
            }
        }
    </script>

</body>

</html>