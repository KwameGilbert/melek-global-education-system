<?php
//Check if user is already logged in and redirect to dashbaord
session_start();

if (isset($_SESSION['student_id'])) {
    header('Location: ../dashboard/');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Melek Global Education - Student Portal</title>
    <link href="https://cdn.tailwindcss.com" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.6.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../../../imports/tailwind/tailwind.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap');

        */ body,
        html {
            height: 95vh;
            font-family: 'Space Grotesk', sans-serif;
            overflow: hidden;
        }

        body {
            background-image: url('../dashboard/images/13643.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0.6) 100%);
            z-index: -1;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        .neon-border {
            position: relative;
        }

        .neon-border::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: inherit;
            padding: 2px;
            background: linear-gradient(45deg, #3B82F6, #2563EB, #10B981);
            -webkit-mask:
                linear-gradient(#fff 0 0) content-box,
                linear-gradient(#fff 0 0);
            mask:
                linear-gradient(#fff 0 0) content-box,
                linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }

        .cyber-input {
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .cyber-input:focus {
            border-color: #3B82F6;
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.3);
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-8px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .float-animation {
            animation: float 3s ease-in-out infinite;
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

<body>
    <div class="overlay"></div>

    <div class="h-full flex items-center justify-center p-4">
        <div class="text-center">
            <!-- Company Title -->
            <div class="mb-4 float-animation">
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">
                    Melek Global Education
                </h1>
                <p class="text-blue-300 text-lg">Empowering Education Through Innovation</p>
            </div>

            <!-- Login Card -->
            <div class="glass-card neon-border rounded-xl w-full max-w-md mx-auto p-8">
                <div class="text-center mb-6">
                    <div class="inline-block p-3 rounded-full bg-blue-500/10 mb-3">
                        <i class="fas fa-graduation-cap text-2xl text-blue-400"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Student Portal Access</h2>
                    <p class="text-blue-300 text-sm mt-1">Web3-Enhanced Learning Platform</p>
                </div>

                <form class="space-y-4">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400 text-sm"></i>
                        </div>
                        <input type="email" id="email"
                            class="cyber-input w-full pl-10 pr-4 py-2.5 rounded-lg text-white placeholder-gray-400 focus:outline-none"
                            placeholder="student@email.com">
                    </div>

                    <div class="relative">
                        <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400 text-sm"></i>
                        </div>
                        <input type="password" id="password"
                            class="cyber-input w-full pl-10 pr-4 py-2.5 rounded-lg text-white placeholder-gray-400 focus:outline-none"
                            placeholder="••••••••">
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center text-gray-300">
                            <input type="checkbox" id='remember' class="mr-2 rounded border-gray-600 text-blue-500 focus:ring-blue-500 bg-transparent">
                            Remember me
                        </label>
                        <a href="../password-reset/" class="text-blue-400 hover:text-blue-300">Forgot?</a>
                    </div>

                    <button type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-blue-500 text-white py-2.5 rounded-lg hover:from-blue-500 hover:to-blue-400 transition-all duration-200 flex items-center justify-center space-x-2 group">
                        <i class="fas fa-sign-in-alt group-hover:rotate-12 transition-transform"></i>
                        <span>Access Portal</span>
                    </button>

                    <div class="text-center text-sm">
                        <span class="text-gray-400">New student?</span>
                        <a href="../signup/" class="text-blue-400 hover:text-blue-300 ml-1">Create Account</a>
                    </div>
                </form>

                <!-- Feature Tags -->
                <div class="flex justify-center gap-2 mt-4">
                    <span class="px-3 py-1 bg-blue-500/10 text-blue-300 rounded-full text-xs">
                        <i class="fas fa-shield-alt mr-1"></i> Secure Access
                    </span>
                    <span class="px-3 py-1 bg-blue-500/10 text-blue-300 rounded-full text-xs">
                        <i class="fas fa-network-wired mr-1"></i> Web3 Enhanced
                    </span>
                </div>
            </div>
        </div>
    </div>
    <script src="./login.min.js"></script>
</body>

</html>