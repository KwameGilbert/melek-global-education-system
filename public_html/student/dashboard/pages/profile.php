<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: /student/login.html');
    exit();
}
?>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-md rounded-lg w-full max-w-4xl mx-auto p-4 lg:p-8">
        <!-- Profile Header -->
        <div class="flex flex-col items-center bg-gradient-to-r from-blue-500 to-indigo-600 py-8 rounded-t-lg relative">
            <label for="profile-image" class="cursor-pointer">
                <img src="<?php echo isset($_SESSION['profile_image']) ? htmlspecialchars($_SESSION['profile_image']) : 'https://avatar.iran.liara.run/public'; ?>" alt="User Avatar"
                    class="w-28 h-28 rounded-full border-4 border-white mb-4">
                <input type="file" id="profile-image" class="hidden" accept="image/*">
            </label>
            <h2 class="text-3xl font-semibold text-white">Edit Profile</h2>
        </div>

        <!-- Profile Form -->
        <div class="p-4">
            <form id="profileForm" onsubmit="updateProfile(event)">
                <!-- Editable Fields -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1" for="name">Name</label>
                        <input type="text" id="name"
                            value="<?php echo htmlspecialchars($_SESSION['firstname'] . ' ' . $_SESSION['lastname']); ?>"
                            class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:border-blue-500"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1" for="email">Email</label>
                        <input type="email" id="email"
                            value="<?php echo htmlspecialchars($_SESSION['email']); ?>"
                            class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:border-blue-500"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1" for="contact">Contact</label>
                        <input type="tel" id="contact"
                            value="<?php echo htmlspecialchars($_SESSION['contact']); ?>"
                            class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:border-blue-500"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1" for="gender">Gender</label>
                        <select id="gender"
                            class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:border-blue-500">
                            <option <?php echo ($_SESSION['gender'] === 'male') ? 'selected' : ''; ?>>Male</option>
                            <option <?php echo ($_SESSION['gender'] === 'female') ? 'selected' : ''; ?>>Female</option>
                            <option <?php echo ($_SESSION['gender'] === 'other') ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1" for="dob">Date of Birth</label>
                        <input type="date" id="dob"
                            value="<?php echo htmlspecialchars($_SESSION['dob']); ?>"
                            class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:border-blue-500"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1" for="nationality">Nationality</label>
                        <input type="text" id="nationality"
                            value="<?php echo htmlspecialchars($_SESSION['nationality']); ?>"
                            class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:border-blue-500"
                            required>
                    </div>
                </div>
                <!-- Update Profile Button -->
                <div class="mt-6">
                    <button type="submit"
                        class="w-full bg-blue-500 text-white font-semibold py-2 rounded-lg hover:bg-blue-600 transition-colors">
                        Update Profile
                    </button>
                </div>
            </form>

            <!-- Change Password Section -->
            <div class="border-t border-gray-200 pt-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Change Password</h3>
                <form id="passwordForm" onsubmit="changePassword(event)">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-2" for="current-password">Current
                            Password</label>
                        <input type="password" id="current-password"
                            class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:border-blue-500"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-2" for="new-password">New
                            Password</label>
                        <input type="password" id="new-password"
                            class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:border-blue-500"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-2" for="confirm-password">Confirm New
                            Password</label>
                        <input type="password" id="confirm-password"
                            class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:border-blue-500"
                            required>
                    </div>
                    <button type="submit"
                        class="w-full bg-blue-500 text-white font-semibold py-2 rounded-lg hover:bg-blue-600 transition-colors">
                        Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>


</body>