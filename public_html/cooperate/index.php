<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Cooperate With Us - Melek Global Consult</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 text-gray-900">
    <!-- Navigation -->
    <?php require_once __DIR__ . '/../components/nav.php'; ?>

    <!-- Hero Section -->
    <section class="bg-cover bg-center h-72" style="background-image: url('https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80');">
        <div class="bg-black bg-opacity-60 h-full flex items-center justify-center">
            <h1 class="text-white text-center text-5xl font-bold">Cooperate With Us</h1>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-12 space-y-16">
       

        <!-- Why Be Our Agent -->
        <section class="bg-white p-8 rounded shadow">
            <h2 class="text-3xl font-bold mb-6 text-center text-blue-600">Why Be Our Agent</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <div>
                    <ul class="list-disc list-inside text-gray-700 space-y-3">
                        <li><strong>Service Fee Discount:</strong> Enjoy higher discounts on service fees as your star status increases.</li>
                        <li><strong>Agent Development:</strong> Benefit from our 4-level agent platform with progressive support and policies to help you reach the highest status.</li>
                        <li><strong>Comprehensive Support:</strong> Beyond our online application system, we invite you to exclusive educational conferences and partner events.</li>
                    </ul>
                </div>
                <div>
                    <img src="https://images.unsplash.com/photo-1557804506-669a67965ba0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&h=600&q=80" alt="Business People Working Together" class="w-full rounded shadow">
                </div>
            </div>
        </section>

        <!-- How to Make Profit -->
        <section class="bg-gray-50 p-8 rounded shadow">
            <h2 class="text-3xl font-bold mb-6 text-center text-blue-600">How to Make Profit</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Individuals Section -->
                <div class="p-4 border rounded">
                    <h3 class="text-2xl font-semibold mb-3">Individuals</h3>
                    <ul class="list-disc list-inside text-gray-700 space-y-2">
                        <li><strong>Open To All:</strong> Registration is free—no matter who you are, you can be our agent.</li>
                        <li><strong>Flexible Working Time:</strong> Promote programs at your own pace using social media platforms like Instagram, Twitter, Facebook, WhatsApp, and WeChat.</li>
                        <li><strong>Good Profit and Support:</strong> Earn through charging reasonable application and service fees while receiving continuous professional training.</li>
                        <li><strong>Upgraded Status Privileges:</strong> Achieve higher status with more applications submitted, earning privileges like authorization letters, service fee discounts, and scholarship seats.</li>
                    </ul>
                </div>
                <!-- Company Agent Section -->
                <div class="p-4 border rounded">
                    <h3 class="text-2xl font-semibold mb-3">Company Agent</h3>
                    <ul class="list-disc list-inside text-gray-700 space-y-2">
                        <li><strong>Abundant Resources:</strong> Gain access to 100+ universities, 10,000+ scholarship seats, and self-financed programs.</li>
                        <li><strong>Cost-Effective Workflow:</strong> Our online system and professional consultants ensure your applications are processed efficiently.</li>
                        <li><strong>Develop Your Company:</strong> Enjoy deepened cooperation with marketing support and institutional connections.</li>
                        <li><strong>Upgraded Status Privileges:</strong> Reach Platinum Status for exclusive benefits such as authorization letters, discounts, and scholarship access.</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- How to Apply as an Agent -->
        <section class="bg-white p-8 rounded shadow">
            <h2 class="text-3xl font-bold mb-6 text-center text-blue-600">How to Apply for Your Student as an Agent</h2>
            <div class="space-y-6">
                <div>
                    <h3 class="text-2xl font-semibold mb-2">1. Register on Our Platform</h3>
                    <p class="text-gray-700">
                        Choose to register as an individual or as a company. After registration, wait for verification. Feedback is provided via email or phone within one workday.
                    </p>
                </div>
                <div>
                    <h3 class="text-2xl font-semibold mb-2">2. Upload the Application</h3>
                    <p class="text-gray-700">
                        Submit your student's documents through our online system. Your consultant will then review and match the documents with a suitable program.
                    </p>
                </div>
                <div>
                    <h3 class="text-2xl font-semibold mb-2">3. Pay the Application Fee</h3>
                    <p class="text-gray-700">
                        Once the fee is paid, your consultant will submit the application to the school. The school will then process and release the result.
                    </p>
                </div>
                <div>
                    <h3 class="text-2xl font-semibold mb-2">4. Get Admission and Pay the Service Fee</h3>
                    <p class="text-gray-700">
                        After admission is secured, pay the service fee. We will then send the original visa documents to you.
                    </p>
                </div>
            </div>
        </section>

         <!-- Agent Registration Form -->
        <section class="bg-white p-8 rounded shadow">
            <h2 class="text-3xl font-bold mb-6 text-center text-blue-600">Become Our Agent</h2>
            <form action="submit_cooperation.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- What Are You -->
                    <div>
                        <label class="block text-gray-700 mb-2">What Are You <span class="text-red-500">*</span></label>
                        <select name="agent_type" required class="w-full p-3 border rounded">
                            <option value="">Select an option</option>
                            <option value="Individual">Individual</option>
                            <option value="Agency">Agency</option>
                            <option value="Educational Institution">Educational Institution</option>
                        </select>
                    </div>
                    <!-- Name Of Institution / Representative -->
                    <div>
                        <label class="block text-gray-700 mb-2">Name (Institution or Representative) <span class="text-red-500">*</span></label>
                        <input type="text" name="name" required class="w-full p-3 border rounded" placeholder="Enter your name or institution name" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Telephone/Mobile Number -->
                    <div>
                        <label class="block text-gray-700 mb-2">Telephone/Mobile Number <span class="text-red-500">*</span></label>
                        <input type="tel" name="phone" required class="w-full p-3 border rounded" placeholder="Enter your phone number" />
                    </div>
                    <!-- Whatsapp/WeChat/Skype ID -->
                    <div>
                        <label class="block text-gray-700 mb-2">Whatsapp/WeChat/Skype ID <span class="text-red-500">*</span></label>
                        <input type="text" name="contact_id" required class="w-full p-3 border rounded" placeholder="Enter your messaging ID" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Country, State, City Of Residence -->
                    <div>
                        <label class="block text-gray-700 mb-2">Country, State, City Of Residence <span class="text-red-500">*</span></label>
                        <input type="text" name="residence" required class="w-full p-3 border rounded" placeholder="E.g. Ghana, Greater Accra, Accra" />
                    </div>
                    <!-- Location -->
                    <div>
                        <label class="block text-gray-700 mb-2">Location <span class="text-red-500">*</span></label>
                        <input type="text" name="location" required class="w-full p-3 border rounded" placeholder="Enter your location" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Business Registration Number -->
                    <div>
                        <label class="block text-gray-700 mb-2">Business Registration Number <span class="text-red-500">*</span></label>
                        <input type="text" name="business_reg" required class="w-full p-3 border rounded" placeholder="Enter registration number" />
                    </div>
                    <!-- Proof Of Accreditation -->
                    <div>
                        <label class="block text-gray-700 mb-2">Proof Of Accreditation <span class="text-red-500">*</span></label>
                        <input type="file" name="accreditation" required class="w-full p-3 border rounded" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Website -->
                    <div>
                        <label class="block text-gray-700 mb-2">Website</label>
                        <input type="url" name="website" class="w-full p-3 border rounded" placeholder="https://yourwebsite.com" />
                    </div>
                    <!-- Employment Status -->
                    <div>
                        <label class="block text-gray-700 mb-2">Employment Status <span class="text-red-500">*</span></label>
                        <select name="employment_status" required class="w-full p-3 border rounded">
                            <option value="">Select an option</option>
                            <option value="Employed">Employed</option>
                            <option value="Self-Employed">Self-Employed</option>
                            <option value="Unemployed">Unemployed</option>
                        </select>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="bg-blue-500 text-white py-3 px-8 rounded hover:bg-blue-600 transition">Submit</button>
                </div>
            </form>
        </section>

        <!-- Newsletter Subscription -->
        <section class="bg-gray-50 p-8 rounded shadow text-center">
            <h2 class="text-3xl font-bold mb-4 text-blue-600">Subscribe To Our Newsletter</h2>
            <form action="subscribe.php" method="POST" class="max-w-md mx-auto space-y-4">
                <div>
                    <input type="text" name="subscriber_name" placeholder="Your Name *" required class="w-full p-3 border rounded" />
                </div>
                <div>
                    <input type="email" name="subscriber_email" placeholder="Email Address *" required class="w-full p-3 border rounded" />
                </div>
                <button type="submit" class="bg-blue-500 text-white py-3 px-6 rounded hover:bg-blue-600 transition">Submit</button>
            </form>
        </section>
    </main>

    <!-- Footer -->
    <?php require_once __DIR__ . '/../components/footer.php'; ?>
</body>

</html>