<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Cooperate With Us - Melek Global Consult</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900">
    <!-- Header (Assuming nav.php contains your navigation) -->
    <?php require_once __DIR__ . '/../components/nav.php'; ?>

    <!-- Hero Section -->
    <section class="bg-cover bg-center h-72" style="background-image: url('https://via.placeholder.com/1200x500?text=Cooperate+With+Us');">
        <div class="bg-black bg-opacity-50 h-full flex items-center justify-center">
            <h1 class="text-white text-5xl font-bold">Cooperate With Us</h1>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-12 space-y-12">
        <!-- Introduction Section -->
        <section class="text-center">
            <h2 class="text-4xl font-bold mb-4">Partner with a Leader in Global Consulting</h2>
            <p class="text-gray-700 text-lg">
                At Melek Global Consult, we build strong partnerships that drive mutual success. Whether you're in the education, travel, or corporate sectors, we invite you to join forces with us to create impactful international opportunities.
            </p>
        </section>

        <!-- Why Partner With Us -->
        <section class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h3 class="text-3xl font-semibold mb-4">Why Partner With Us?</h3>
                <ul class="list-disc list-inside text-gray-700 space-y-2">
                    <li><strong>Proven Track Record:</strong> We have a history of securing scholarships, visa approvals, and travel documents for our clients.</li>
                    <li><strong>Expert Guidance:</strong> Our experienced team expertly navigates the complexities of international education, travel, and work.</li>
                    <li><strong>Global Network:</strong> Leverage our extensive connections with partner institutions and industry leaders worldwide.</li>
                    <li><strong>Innovative Solutions:</strong> We continually innovate to provide tailored solutions that meet your unique needs.</li>
                </ul>
            </div>
            <div>
                <img src="https://images.unsplash.com/photo-1553484771-047a44eee27a?auto=format&fit=crop&q=80" alt="Business partnership handshake" class="w-full h-full object-cover rounded shadow">
            </div>
        </section>

        <!-- Our Partnership Model -->
        <section class="bg-white p-8 rounded shadow">
            <h3 class="text-3xl font-semibold mb-4">Our Partnership Model</h3>
            <p class="text-gray-700 mb-4">
                We offer a flexible and dynamic partnership model tailored to various industries. Explore the collaboration opportunities below:
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-4 border rounded">
                    <h4 class="text-xl font-bold mb-2">Educational Institutions</h4>
                    <p class="text-gray-600">
                        Join us to offer your students international opportunities—from securing admissions and scholarships to pre-departure guidance.
                    </p>
                </div>
                <div class="p-4 border rounded">
                    <h4 class="text-xl font-bold mb-2">Travel & Tourism Agencies</h4>
                    <p class="text-gray-600">
                        Enhance your travel packages with our comprehensive services, including flight bookings, accommodation, and visa assistance.
                    </p>
                </div>
                <div class="p-4 border rounded">
                    <h4 class="text-xl font-bold mb-2">Corporate Partners</h4>
                    <p class="text-gray-600">
                        Collaborate with us to facilitate work abroad and business travel solutions that empower your global growth.
                    </p>
                </div>
            </div>
        </section>

        <!-- How to Get Started -->
        <section class="text-center">
            <h3 class="text-3xl font-semibold mb-4">How to Get Started</h3>
            <p class="text-gray-700 mb-6">
                Ready to explore a strategic partnership with Melek Global Consult? Contact our team today to discuss collaboration opportunities designed for your success.
            </p>
            <a href="contact.php" class="inline-block bg-blue-500 text-white py-3 px-6 rounded hover:bg-blue-600 transition">
                Contact Us Today
            </a>
        </section>

        <!-- Inquiry Form -->
        <section class="bg-gray-50 p-8 rounded shadow">
            <h3 class="text-3xl font-semibold mb-4 text-center">Inquiry Form</h3>
            <form action="submit_inquiry.php" method="POST" class="max-w-2xl mx-auto space-y-4">
                <div>
                    <label for="name" class="block text-gray-700">Name</label>
                    <input type="text" id="name" name="name" required class="w-full p-3 border rounded">
                </div>
                <div>
                    <label for="email" class="block text-gray-700">Email</label>
                    <input type="email" id="email" name="email" required class="w-full p-3 border rounded">
                </div>
                <div>
                    <label for="subject" class="block text-gray-700">Subject</label>
                    <input type="text" id="subject" name="subject" required class="w-full p-3 border rounded">
                </div>
                <div>
                    <label for="message" class="block text-gray-700">Message</label>
                    <textarea id="message" name="message" rows="5" required class="w-full p-3 border rounded"></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" class="bg-blue-500 text-white py-3 px-6 rounded hover:bg-blue-600 transition">
                        Submit Inquiry
                    </button>
                </div>
            </form>
        </section>
    </main>

    <!-- Footer -->
    <?php require_once __DIR__ . '/../components/footer.php'; ?>
</body>

</html>