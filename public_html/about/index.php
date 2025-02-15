<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>About Us - Melek Global Consult</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900">
    <!-- Header -->
    <?php require_once __DIR__ . '/../components/nav.php'; ?>

    <!-- Hero Section -->
    <section class="bg-cover bg-center h-72" style="background-image: url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&h=500&q=80');">
        <div class="bg-black bg-opacity-50 h-full flex items-center justify-center">
            <h1 class="text-white text-5xl font-bold">About Us</h1>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-12 space-y-16">
        <!-- Our Story -->
        <section>
            <h2 class="text-3xl font-semibold mb-4">Our Story</h2>
            <p class="text-gray-700 leading-relaxed">
                Melek Global Consult was founded with a single vision—to provide a guiding light for students, professionals, and travelers seeking opportunities abroad. Our journey began with a passion for bridging gaps between aspirations and reality. Owned and led by Mr. Bright Asamoah Gyapong and Mr. Fredrick Asamoah Gyapong, we have grown into a trusted consultancy that helps clients secure admissions in top educational institutions, gain employment opportunities overseas, and experience seamless travel.
            </p>
        </section>

        <!-- Our Mission -->
        <section>
            <h2 class="text-3xl font-semibold mb-4">Our Mission</h2>
            <p class="text-gray-700 leading-relaxed">
                Our mission is to empower you with the resources and expert guidance you need to achieve your international dreams. Whether you are looking to study abroad, book your flight, secure a job overseas, or find comfortable accommodations, Melek Global Consult is dedicated to ensuring that every step of your journey is smooth and successful. We strive to be the light at the end of the tunnel, offering personalized solutions tailored to your unique needs.
            </p>
        </section>

        <!-- What We Do -->
        <section>
            <h2 class="text-3xl font-semibold mb-4">What We Do</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white p-6 rounded shadow">
                    <h3 class="text-2xl font-semibold mb-2">Education Consulting</h3>
                    <p class="text-gray-700">
                        We assist students in securing admissions into top-tier international educational institutions. Our services include application support, document preparation, and interview coaching to help you realize your academic aspirations.
                    </p>
                </div>
                <div class="bg-white p-6 rounded shadow">
                    <h3 class="text-2xl font-semibold mb-2">Travel & Flight Booking</h3>
                    <p class="text-gray-700">
                        From finding the best flight deals to planning your travel itinerary, our travel services ensure you embark on your journey stress-free. We help you navigate the complexities of international travel.
                    </p>
                </div>
                <div class="bg-white p-6 rounded shadow">
                    <h3 class="text-2xl font-semibold mb-2">Work Abroad Assistance</h3>
                    <p class="text-gray-700">
                        Our work abroad services are designed to help professionals secure job opportunities and work permits overseas. We provide guidance on visa applications and employment procedures to kickstart your international career.
                    </p>
                </div>
                <div class="bg-white p-6 rounded shadow">
                    <h3 class="text-2xl font-semibold mb-2">Accommodation & Hotel Booking</h3>
                    <p class="text-gray-700">
                        Ensuring your stay is comfortable and hassle-free is our priority. We offer assistance in booking accommodations and hotels that suit your needs, whether you're a student, a professional, or a tourist.
                    </p>
                </div>
                <div class="bg-white p-6 rounded shadow md:col-span-2">
                    <h3 class="text-2xl font-semibold mb-2">Visa & Residence Permit Assistance</h3>
                    <p class="text-gray-700">
                        Navigating visa and residence permit processes can be overwhelming. Our team provides comprehensive support—from documentation to processing—ensuring you have a smooth transition into your new country.
                    </p>
                </div>
            </div>
        </section>

        <!-- Our Values -->
        <section>
            <h2 class="text-3xl font-semibold mb-4">Our Values</h2>
            <ul class="list-disc pl-6 text-gray-700 space-y-2">
                <li><strong>Integrity:</strong> We conduct our business with honesty and transparency.</li>
                <li><strong>Excellence:</strong> We are committed to providing high-quality services and exceptional support.</li>
                <li><strong>Innovation:</strong> We continuously seek new ways to improve our offerings and exceed client expectations.</li>
                <li><strong>Customer Focus:</strong> Your success and satisfaction are at the heart of everything we do.</li>
            </ul>
        </section>

        <!-- Meet the Team -->
        <section>
            <h2 class="text-3xl font-semibold mb-4">Meet the Team</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                <!-- Team Member 1 -->
                <div class="bg-white p-6 rounded shadow text-center">
                    <img src="https://via.placeholder.com/150?text=Team+Member" alt="Team Member" class="w-32 h-32 rounded-full mx-auto mb-4 object-cover" />
                    <h3 class="text-xl font-semibold">Mr. Bright Asamoah Gyapong</h3>
                    <p class="text-gray-600">Co-Founder</p>
                </div>
                <!-- Team Member 2 -->
                <div class="bg-white p-6 rounded shadow text-center">
                    <img src="https://via.placeholder.com/150?text=Team+Member" alt="Team Member" class="w-32 h-32 rounded-full mx-auto mb-4 object-cover" />
                    <h3 class="text-xl font-semibold">Mr. Fredrick Asamoah Gyapong</h3>
                    <p class="text-gray-600">Co-Founder</p>
                </div>
                <!-- Additional team members can be added here -->
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php require_once __DIR__ . '/../components/footer.php'; ?>
</body>

</html>