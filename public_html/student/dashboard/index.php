<?php
$databaseFile = __DIR__ . '/../../config/database.php';
if (!file_exists($databaseFile)) {
    die('Database configuration file not found');
}
require $databaseFile;

// Start PHP session
session_start();

// Check if the user is logged in by verifying session variables
if (isset($_SESSION['student_id'])) {
} else {
    // Redirect to login if session is not set
    header('Location: ' . __DIR__ . '/../');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Melek Global Education</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.tailwindcss.com" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.6.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../../imports/tailwind/tailwind.min.css">
    <style>
        .hidden {
            display: none;
        }

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
    <div id="sidebar"
        class="bg-gray-800 text-white w-64 space-y-6 py-7 px-2 absolute inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition duration-500 ease-in-out overflow-y-auto z-50">

        <!-- Close Button for Small Screens -->
        <div class="md:hidden flex justify-end pr-4">
            <button class="text-gray-400 hover:text-white focus:outline-none" onclick="toggleSidebar()">
                <i class="fas fa-times h-6 w-6"></i>
            </button>
        </div>

        <!-- Profile Section -->
        <div class="flex flex-col items-center mb-6">
            <img src="<?php echo isset($_SESSION['profile_image']) && $_SESSION['profile_image'] ? htmlspecialchars($_SESSION['profile_image']) : 'https://avatar.iran.liara.run/public'; ?>" alt="User Avatar"
                class="w-28 h-28 rounded-full border-4 border-white mb-4">

            <h2 class="text-lg font-semibold" id="studentName">
                <?php echo $_SESSION['firstname'] . ' ' . $_SESSION['lastname']  ?></h2>
            <p class="text-sm text-gray-400" id="studentEmail"><?php echo $_SESSION['email'] ?></p>
        </div>

        <!-- Navigation -->
        <nav class="space-y-2">
            <a href="#" data-page="dashboard.html" class="flex items-center py-2.5 px-4 hover:bg-gray-700">
                <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
            </a>
            <a href="#" data-page="profile.php" class="flex items-center py-2.5 px-4 hover:bg-gray-700">
                <i class="fas fa-user mr-3"></i> Profile
            </a>
            <a href="#" data-page="application.php" class="flex items-center py-2.5 px-4 hover:bg-gray-700">
                <i class="fas fa-folder-open mr-3"></i> Application
            </a>
            <a href="#" data-page="payments.php" class="flex items-center py-2.5 px-4 hover:bg-gray-700">
                <i class="fas fa-money-check-alt mr-3"></i> Payments
            </a>
            <a href="#" data-page="notices.html" class="flex items-center py-2.5 px-4 hover:bg-gray-700">
                <i class="fas fa-bell mr-3"></i> Notices
            </a>
        </nav>
    </div>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col md:relative md:z-10 bg-white overflow-y-auto">
        <!-- Header -->
        <header class="shadow w-full flex items-center justify-between p-4">
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
        <main id="main-content" class="flex-1 overflow-y-auto p-6 pt-0 bg-white shadow-lg rounded-lg">
            <!-- Dynamic content will be loaded here -->
        </main>
    </div>

    <script src="./scripts/index.min.js"></script>
    <script src="./scripts/profile.min.js"></script>
    <script src="./scripts/application.min.js"></script>
    <script src="./scripts/payment.min.js"></script>
    <script>
        // Toggle sidebar visibility
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full');
            document.body.classList.toggle('overflow-hidden'); // Prevent scrolling when sidebar is open

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

        window.onload = function() {
            const activePage = localStorage.getItem('activePage') || 'dashboard.html'; // Default to 'dashboard.html'
            loadPage(activePage);
        };
    </script>
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
</body>

</html>