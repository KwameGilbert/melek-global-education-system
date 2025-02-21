<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Contact Us - Melek Global Consult</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 text-gray-900">
    <!-- Navigation -->
    <?php require_once __DIR__ . '/../components/nav.php'; ?>

    <!-- Hero Section -->
    <section class="bg-cover bg-center h-72" style="background-image: url('https://images.unsplash.com/photo-1616587226960-4a03badbe8bf?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&h=900&q=80');">
        <div class="bg-black bg-opacity-60 h-full flex items-center justify-center">
            <h1 class="text-white text-5xl font-bold">Contact Us</h1>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-12 space-y-16">
        <!-- Contact Information and Branches -->
        <section class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <!-- Global Contact Details and Branch Info -->
            <div class="space-y-6">
                <h2 class="text-3xl font-bold">Get in Touch</h2>
                <p class="text-gray-700 leading-relaxed">
                    If you have any questions, need support, or wish to discuss opportunities, please reach out. We are here to help.
                </p>
                <div class="space-y-4">
                    <div>
                        <span class="font-semibold">Phone:</span>
                        <a href="tel:+8618864506806" class="text-blue-500 hover:underline">+86 188 64506806</a>
                    </div>
                    <div>
                        <span class="font-semibold">Email:</span>
                        <a href="mailto:melekglobalconsult@gmail.com" class="text-blue-500 hover:underline">melekglobalconsult@gmail.com</a>
                    </div>
                </div>
                <!-- Branch Details -->
                <div class="mt-8">
                    <h3 class="text-2xl font-bold mb-4">Our Branches</h3>
                    <div class="space-y-4">
                        <!-- UK Branch -->
                        <div>
                            <h4 class="font-semibold">UK Branch</h4>
                            <p>128 City Road, London, United Kingdom, EC1V 2NX</p>
                            <p>
                                <span class="font-semibold">Phone:</span>
                                <a href="tel:+447441476843" class="text-blue-500 hover:underline">+44 7441 476843</a>
                            </p>
                        </div>
                        <!-- Zambia Branch -->
                        <div>
                            <h4 class="font-semibold">Zambia Branch</h4>
                            <p>Unit 12 on Sub 1/A/L1691/M, First Floor, Ibex Hub Shopping Centre, 1st Street, Ibex Hill, Lusaka</p>
                            <p>
                                <span class="font-semibold">Phone:</span>
                                <a href="tel:+260769481206" class="text-blue-500 hover:underline">+260 769 481 206</a> /
                                <a href="tel:+260769481196" class="text-blue-500 hover:underline">+260 769 481196</a>
                            </p>
                        </div>
                        <!-- Ghana Branch -->
                        <div>
                            <h4 class="font-semibold">Ghana Branch</h4>
                            <p>
                                <span class="font-semibold">Phone:</span>
                                <a href="tel:+233544245483" class="text-blue-500 hover:underline">+233 54 424 5483</a>
                            </p>
                        </div>
                        <!-- Zimbabwe Branch -->
                        <div>
                            <h4 class="font-semibold">Zimbabwe Branch</h4>
                            <p>No 8 Birchenough Road, Belgravia, Harare</p>
                        </div>
                    </div>
                </div>
                <!-- Social Media -->
                <div class="mt-8">
                    <h3 class="font-semibold">Follow Us</h3>
                    <div class="flex space-x-4">
                        <a href="https://m.facebook.com" target="_blank" class="text-blue-600 hover:text-blue-800">
                            <i class="fab fa-facebook fa-2x"></i>
                        </a>
                        <a href="https://www.instagram.com" target="_blank" class="text-pink-600 hover:text-pink-800">
                            <i class="fab fa-instagram fa-2x"></i>
                        </a>
                        <a href="https://www.youtube.com" target="_blank" class="text-red-600 hover:text-red-800">
                            <i class="fab fa-youtube fa-2x"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Map Image -->
            <div>
                <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&h=900&q=80" alt="World Map" class="w-full rounded shadow">
            </div>
        </section>

        <!-- Contact Form -->
        <section class="bg-white p-8 rounded shadow">
            <h2 class="text-3xl font-bold mb-6 text-center">Send Us a Message</h2>
            <form action="submit_contact.php" method="POST" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-gray-700 mb-2">Your Name *</label>
                        <input type="text" id="name" name="name" required class="w-full p-3 border rounded" placeholder="Enter your name">
                    </div>
                    <div>
                        <label for="email" class="block text-gray-700 mb-2">Your Email *</label>
                        <input type="email" id="email" name="email" required class="w-full p-3 border rounded" placeholder="Enter your email">
                    </div>
                </div>
                <div>
                    <label for="subject" class="block text-gray-700 mb-2">Subject *</label>
                    <input type="text" id="subject" name="subject" required class="w-full p-3 border rounded" placeholder="Enter your subject">
                </div>
                <div>
                    <label for="message" class="block text-gray-700 mb-2">Message *</label>
                    <textarea id="message" name="message" rows="5" required class="w-full p-3 border rounded" placeholder="Type your message here"></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" class="bg-blue-500 text-white py-3 px-8 rounded hover:bg-blue-600 transition">
                        Send Message
                    </button>
                </div>
            </form>
        </section>
    </main>

    <!-- Footer -->
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