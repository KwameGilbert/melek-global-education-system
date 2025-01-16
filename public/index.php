<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Melek Global Consult - Your Educational Journey Partner</title>
    <script src=""></script>
        <link rel="stylesheet" href="../imports/tailwind/tailwind.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .partners-slider {
            display: flex;
            overflow: hidden;
            width: 100%;
            user-select: none;
        }

        .partners-track {
            display: flex;
            animation: slide 20s linear infinite;
        }

        .partners-track:hover {
            animation-play-state: paused;
        }

        @keyframes slide {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .mobile-scroll {
            overflow-x: scroll;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
        }

        .mobile-scroll::-webkit-scrollbar {
            display: none;
        }

        .scroll-item {
            scroll-snap-align: center;
            flex-shrink: 0;
        }

        /* WhatsApp */
        .whatsapp-float {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .whatsapp-float:hover {
            transform: scale(1.1);
        }

        .whatsapp-float .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>
</head>

<body class="bg-white text-gray-800 font-sans leading-normal">
    <!-- Navigation -->
    <nav class="sticky top-0 bg-white shadow-md z-50">
        <div class="container mx-auto px-4 py-3 flex flex-col md:flex-row justify-between items-center align-center">
            <div class="w-full flex justify-between items-center mb-4 md:mb-0">
                <img src="https://melekglobalconsult.com/wp-content/uploads/2021/08/malik-global1.png" alt="Melek Global Consult Logo" class="h-12">
                <button class="md:hidden" onclick="toggleMobileMenu()">
                    <i data-feather="menu" class="text-blue-600"></i>
                </button>
            </div>
            <div id="mobileMenu" class="hidden md:block w-full md:w-auto">
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-6 items-center justify-center md:justify-end">
                    <a href="#" class="text-blue-600 hover:text-blue-800 font-semibold">Home</a>
                    <a href="#services" class="text-blue-600 hover:text-blue-800 font-semibold">Services</a>
                    <a href="#about" class="text-blue-600 hover:text-blue-800 font-semibold">About</a>
                    <a href="#contact" class="bg-blue-600 text-white px-7 py-2 rounded-full hover:bg-blue-700 transition whitespace-nowrap">Contact Us</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="bg-gradient-to-br from-blue-500 to-blue-700 text-white py-20">
        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center">
            <div class="w-full md:w-1/2 md:pr-10 text-center md:text-left mb-8 md:mb-0">
                <h1 class="text-3xl md:text-5xl font-bold mb-6">Your Global Education Journey Starts Here</h1>
                <p class="text-lg md:text-xl mb-8">Confused about your next study destination? We're on a mission to help you make the best out of your life. Your bright future is our priority.</p>
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 justify-center md:justify-start flex-wrap md:flex-nowrap">
                    <a href="#services" class="bg-white text-blue-600 px-6 py-3 rounded-full font-semibold hover:bg-blue-50 transition whitespace-nowrap"> Services</a>
                    <a href="#contact" class="border-2 border-white text-white px-6 py-3 rounded-full hover:bg-white hover:text-blue-600 transition whitespace-nowrap">Book Consultation</a>
                </div>
            </div>
            <div class="w-full md:w-1/2">
                <img src="https://img.freepik.com/free-photo/young-student-working-assignment_23-2149257177.jpg?t=st=1734312110~exp=1734315710~hmac=30294f23749b426d086cbb521d218d9550e02154472712740483c54c031fc83a&w=740" alt="Student Studying" class="rounded-xl shadow-2xl w-full">
            </div>
        </div>
    </header>

    <!-- Achievements Section (previously in the original script) -->
    <section id="achievements" class="bg-blue-50 py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-blue-800">Our Achievements</h2>
                <p class="text-lg md:text-xl text-gray-600 mt-4">A testament to our commitment and success</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-8" id="achievementGrid">
                <!-- Achievement items will be dynamically populated -->
            </div>

        </div>


    </section>

    <!-- Services Section -->
    <section id="services" class="container mx-auto py-20 px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Our Educational Services</h2>
            <p class="text-lg md:text-xl text-gray-600">Comprehensive support for your global education journey</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white shadow-lg rounded-xl p-8 text-center hover:shadow-2xl transition">
                <i data-feather="globe" class="mx-auto mb-6 text-blue-600" stroke-width="1.5" width="64" height="64"></i>
                <h3 class="text-xl md:text-2xl font-semibold mb-4">Study Abroad</h3>
                <p>We help students apply to top international universities, handling documentation and admission processes.</p>
            </div>
            <div class="bg-white shadow-lg rounded-xl p-8 text-center hover:shadow-2xl transition">
                <i data-feather="file-text" class="mx-auto mb-6 text-blue-600" stroke-width="1.5" width="64" height="64"></i>
                <h3 class="text-xl md:text-2xl font-semibold mb-4">Visa Assistance</h3>
                <p>Complete support for visa applications, interview preparations, and residence permit documentation.</p>
            </div>
            <div class="bg-white shadow-lg rounded-xl p-8 text-center hover:shadow-2xl transition">
                <i data-feather="home" class="mx-auto mb-6 text-blue-600" stroke-width="1.5" width="64" height="64"></i>
                <h3 class="text-xl md:text-2xl font-semibold mb-4">Accommodation</h3>
                <p>Secure and comfortable housing arrangements before your arrival at international campuses.</p>
            </div>
        </div>
    </section>

    <!-- Partners -->
    <section class="py-16 px-4">
        <div class="container mx-auto">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Our Partners</h2>
            <!-- Desktop Slider (Automatic) -->
            <div class="hidden md:block partners-slider">
                <div class="partners-track">
                    <!-- Duplicate the track for seamless looping -->
                    <div class="flex items-center justify-around w-full">
                        <img src="https://melekglobalconsult.com/wp-content/uploads/2021/08/1519950915656-1-150x150.png" alt="Partner Logo" class="mx-8 h-32  transition-all duration-300">
                        <img src="https://melekglobalconsult.com/wp-content/uploads/2021/08/1562580080407-1-150x150.png" alt="Partner Logo" class="mx-8 h-32  transition-all duration-300">
                        <img src="https://melekglobalconsult.com/wp-content/uploads/2021/08/eventlogo-90-1586871559-1-150x150.jpg" alt="Partner Logo" class="mx-8 h-32  transition-all duration-300">
                        <img src="https://melekglobalconsult.com/wp-content/uploads/2021/08/1569598209020-1-150x150.jpeg" alt="Partner Logo" class="mx-8 h-32  transition-all duration-300">
                        <img src="https://melekglobalconsult.com/wp-content/uploads/2021/08/sf_asia_logo-1-150x123.png" alt="Partner Logo" class="mx-8 h-32  transition-all duration-300">
                        <img src="https://melekglobalconsult.com/wp-content/uploads/2021/08/1519950915656-1-150x150.png" alt="Partner Logo" class="mx-8 h-32  transition-all duration-300">
                        <img src="https://melekglobalconsult.com/wp-content/uploads/2021/08/1562580080407-1-150x150.png" alt="Partner Logo" class="mx-8 h-32  transition-all duration-300">
                        <img src="https://melekglobalconsult.com/wp-content/uploads/2021/08/eventlogo-90-1586871559-1-150x150.jpg" alt="Partner Logo" class="mx-8 h-32  transition-all duration-300">
                        <img src="https://melekglobalconsult.com/wp-content/uploads/2021/08/1569598209020-1-150x150.jpeg" alt="Partner Logo" class="mx-8 h-32  transition-all duration-300">
                        <img src="https://melekglobalconsult.com/wp-content/uploads/2021/08/sf_asia_logo-1-150x123.png" alt="Partner Logo" class="mx-8 h-32  transition-all duration-300">
                        <img src="https://melekglobalconsult.com/wp-content/uploads/2021/08/1519950915656-1-150x150.png" alt="Partner Logo" class="mx-8 h-32  transition-all duration-300">
                        <img src="https://melekglobalconsult.com/wp-content/uploads/2021/08/1562580080407-1-150x150.png" alt="Partner Logo" class="mx-8 h-32  transition-all duration-300">
                        <img src="https://melekglobalconsult.com/wp-content/uploads/2021/08/eventlogo-90-1586871559-1-150x150.jpg" alt="Partner Logo" class="mx-8 h-32  transition-all duration-300">
                        <img src="https://melekglobalconsult.com/wp-content/uploads/2021/08/1569598209020-1-150x150.jpeg" alt="Partner Logo" class="mx-8 h-32  transition-all duration-300">
                        <img src="https://melekglobalconsult.com/wp-content/uploads/2021/08/sf_asia_logo-1-150x123.png" alt="Partner Logo" class="mx-8 h-32  transition-all duration-300">
                        <img src="https://melekglobalconsult.com/wp-content/uploads/2021/08/1519950915656-1-150x150.png" alt="Partner Logo" class="mx-8 h-32  transition-all duration-300">
                        <img src="https://melekglobalconsult.com/wp-content/uploads/2021/08/1562580080407-1-150x150.png" alt="Partner Logo" class="mx-8 h-32  transition-all duration-300">
                        <img src="https://melekglobalconsult.com/wp-content/uploads/2021/08/eventlogo-90-1586871559-1-150x150.jpg" alt="Partner Logo" class="mx-8 h-32  transition-all duration-300">
                        <img src="https://melekglobalconsult.com/wp-content/uploads/2021/08/1569598209020-1-150x150.jpeg" alt="Partner Logo" class="mx-8 h-32  transition-all duration-300">
                        <img src="https://melekglobalconsult.com/wp-content/uploads/2021/08/sf_asia_logo-1-150x123.png" alt="Partner Logo" class="mx-8 h-32  transition-all duration-300">
                    </div>

                </div>
            </div>

            <!-- Mobile Slider (Touch Scroll) -->
            <div class="md:hidden mobile-scroll flex overflow-x-scroll no-scrollbar">
                <div class="scroll-item flex-shrink-0 flex items-center justify-center mx-4">
                    <img src="https://melekglobalconsult.com/wp-content/uploads/2021/08/sf_asia_logo-1-150x123.png" alt="Partner Logo" class="h-32  transition-all duration-300">
                </div>
                <div class="scroll-item flex-shrink-0 flex items-center justify-center mx-4">
                    <img src="https://melekglobalconsult.com/wp-content/uploads/2021/08/1562580080407-1-150x150.png" alt="Partner Logo" class="h-32  transition-all duration-300">
                </div>
                <div class="scroll-item flex-shrink-0 flex items-center justify-center mx-4">
                    <img src="https://melekglobalconsult.com/wp-content/uploads/2021/08/eventlogo-90-1586871559-1-150x150.jpg" alt="Partner Logo" class="h-32  transition-all duration-300">
                </div>
                <div class="scroll-item flex-shrink-0 flex items-center justify-center mx-4">
                    <img src="https://melekglobalconsult.com/wp-content/uploads/2021/08/1569598209020-1-150x150.jpeg" alt="Partner Logo" class="h-32  transition-all duration-300">
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="bg-gray-100 py-20">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Success Stories</h2>
                <p class="text-lg md:text-xl text-gray-600">Students who transformed their futures with us</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-xl shadow-md">
                    <p class="italic mb-4">"Never knew studying abroad could be so easy and stress-free until I met Melek Global Consult."</p>
                    <div class="flex items-center">
                        <div class="mr-4">
                            <img src="https://melekglobalconsult.com/wp-content/uploads/2021/08/mm.jpg" alt="Client" class="rounded-full" style="border-radius: 50%;">
                        </div>
                        <div>
                            <h4 class="font-semibold">Chiedozie David Okoye</h4>
                            <p class="text-gray-600">Student</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-md">
                    <p class="italic mb-4">"They helped me secure a partial scholarship to study Communication Engineering in China."</p>
                    <div class="flex items-center">
                        <div class="mr-4">
                            <img src="https://melekglobalconsult.com/wp-content/uploads/2021/08/kk.jpg" alt="Client" class="rounded-full">
                        </div>
                        <div>
                            <h4 class="font-semibold">Osei Tutu Louis</h4>
                            <p class="text-gray-600">Scholarship Recipient</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-md">
                    <p class="italic mb-4">"Helped me secure admission to study Polish Language in Poland. Made the process so simple."</p>
                    <div class="flex items-center">
                        <div class="mr-4">
                            <img src="https://melekglobalconsult.com/wp-content/uploads/2021/09/imagepdf-18_Page_1.png" alt="Client" class="rounded-full">
                        </div>
                        <div>
                            <h4 class="font-semibold">Zac Armand Mbombe</h4>
                            <p class="text-gray-600">International Student</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="container mx-auto py-20 px-4">
        <div class="bg-blue-600 text-white rounded-xl p-8 md:p-16 flex flex-col md:flex-row items-center">
            <div class="w-full md:w-1/2 md:pr-10 text-center md:text-left mb-8 md:mb-0">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Ready to Start Your Journey?</h2>
                <p class="text-lg md:text-xl mb-8">Book a free consultation with our expert counselors and take the first step towards your global education dream.</p>
                <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4">
                    <div class="flex items-center space-x-4">
                        <i data-feather="phone" class="text-white" width="32" height="32"></i>
                        <span class="text-xl md:text-2xl font-semibold">+86 188 64506806</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <i data-feather="mail" class="text-white" width="32" height="32"></i>
                        <span class="text-lg md:text-xl">melekglobalconsult@gmail.com</span>
                    </div>
                </div>
            </div>
            <div class="w-full md:w-1/2">
                <form class="bg-white p-8 rounded-xl shadow-2xl">
                    <h3 class="text-xl md:text-2xl font-semibold mb-6 text-gray-800">Schedule Your Consultation</h3>
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Full Name</label>
                        <input type="text" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter your name">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Email Address</label>
                        <input type="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter your email">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Your Message</label>
                        <textarea class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" rows="4" placeholder="Tell us about your educational goals"></textarea>
                    </div>
                    <button class="w-full bg-blue-600 text-white py-3 rounded-full hover:bg-blue-700 transition">Schedule Consultation</button>
                </form>
            </div>
        </div>
    </section>

    <!-- WhatsApp Float Icon -->
    <a href="https://wa.me/8618864506806"
        target="_blank"
        rel="noopener noreferrer"
        class="whatsapp-float">
        <div class="bg-green-500 text-white w-16 h-16 rounded-full flex items-center justify-center shadow-2xl pulse">
            <i class="fab fa-whatsapp text-4xl"></i>
        </div>
    </a>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-4 grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="col-span-2 md:col-span-1">
                <h4 class="text-xl font-semibold mb-4">Melek Global Consult</h4>
                <p class="text-gray-400">Your trusted partner in global education and travel solutions.</p>
            </div>
            <div>
                <h4 class="text-xl font-semibold mb-4">Quick Links</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-400 hover:text-white">Home</a></li>
                    <li><a href="#services" class="text-gray-400 hover:text-white">Services</a></li>
                    <li><a href="#about" class="text-gray-400 hover:text-white">About Us</a></li>
                    <li><a href="#contact" class="text-gray-400 hover:text-white">Contact</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-xl font-semibold mb-4">Connect With Us</h4>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white"><i data-feather="facebook" width="24" height="24"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i data-feather="instagram" width="24" height="24"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i data-feather="youtube" width="24" height="24"></i></a>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <h4 class="text-xl font-semibold mb-4">Contact Info</h4>
                <p class="text-gray-400 mb-2">+86 188 64506806</p>
                <p class="text-gray-400">teterestral@gmail.com</p>
            </div>
        </div>
        <div class="container mx-auto px-4 mt-8 pt-4 border-t border-gray-800 text-center">
            <p class="text-gray-500">© 2024 Melek Global Consult. All Rights Reserved.</p>
        </div>
    </footer>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const mobileSlider = document.querySelector('.mobile-scroll');
            const scrollItems = document.querySelectorAll('.scroll-item');

            // Clone items to create an infinite loop effect
            scrollItems.forEach(item => {
                const clone = item.cloneNode(true);
                mobileSlider.appendChild(clone);
            });

            let isDown = false;
            let startX;
            let scrollLeft;

            mobileSlider.addEventListener('mousedown', (e) => {
                isDown = true;
                startX = e.pageX - mobileSlider.offsetLeft;
                scrollLeft = mobileSlider.scrollLeft;
            });

            mobileSlider.addEventListener('mouseleave', () => {
                isDown = false;
            });

            mobileSlider.addEventListener('mouseup', () => {
                isDown = false;
            });

            mobileSlider.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - mobileSlider.offsetLeft;
                const walk = (x - startX) * 2; // Adjust speed
                mobileSlider.scrollLeft = scrollLeft - walk;

                // Seamless looping logic
                if (mobileSlider.scrollLeft >= mobileSlider.scrollWidth / 2) {
                    mobileSlider.scrollLeft = 0; // Reset to start
                } else if (mobileSlider.scrollLeft <= 0) {
                    mobileSlider.scrollLeft = mobileSlider.scrollWidth / 2; // Jump to end
                }
            });

            // Optional: Add touch interaction for mobile
            let touchStartX;
            mobileSlider.addEventListener('touchstart', (e) => {
                touchStartX = e.touches[0].pageX;
                scrollLeft = mobileSlider.scrollLeft;
            });

            mobileSlider.addEventListener('touchmove', (e) => {
                e.preventDefault();
                const touchX = e.touches[0].pageX;
                const walk = (touchX - touchStartX) * 2;
                mobileSlider.scrollLeft = scrollLeft - walk;

                // Seamless looping logic
                if (mobileSlider.scrollLeft >= mobileSlider.scrollWidth / 2) {
                    mobileSlider.scrollLeft = 0;
                } else if (mobileSlider.scrollLeft <= 0) {
                    mobileSlider.scrollLeft = mobileSlider.scrollWidth / 2;
                }
            });
        });







        // Achievements Data with Web3-inspired Metadata
        const achievements = [{
                label: 'Years Of Experience',
                value: 5,
                icon: 'clock',
                gradient: 'from-blue-500 to-purple-600',
                description: 'Verified Expertise'
            },
            {
                label: 'Partner Schools',
                value: 50,
                icon: 'globe',
                gradient: 'from-green-400 to-blue-500',
                description: 'Global Network'
            },
            {
                label: 'Admitted Students',
                value: 500,
                icon: 'users',
                gradient: 'from-pink-500 to-red-500',
                description: 'Successful Journeys'
            },
            {
                label: 'Partner Agents',
                value: 50,
                icon: 'briefcase',
                gradient: 'from-yellow-400 to-orange-500',
                description: 'Strategic Partnerships'
            },
            {
                label: 'Travelers Helped',
                value: 100,
                icon: 'map-pin',
                gradient: 'from-teal-400 to-blue-500',
                description: 'Borderless Connections'
            },
            {
                label: 'Jobs Secured',
                value: 45,
                icon: 'trending-up',
                gradient: 'from-purple-500 to-indigo-600',
                description: 'Career Acceleration'
            }
        ];

        // Advanced Achievement Renderer
        class AchievementsRenderer {
            constructor(achievements, gridSelector) {
                this.achievements = achievements;
                this.grid = document.querySelector(gridSelector);
                this.observer = null;
            }

            // Create glowing, animated achievement cards
            createAchievementCards() {
                if (!this.grid) {
                    console.error('Achievement grid not found');
                    return;
                }

                this.grid.innerHTML = ''; // Clear existing content

                this.achievements.forEach((achievement, index) => {
                    const card = document.createElement('div');
                    card.classList.add(
                        'achievement-card',
                        'relative',
                        'overflow-hidden',
                        'rounded-2xl',
                        'shadow-xl',
                        'transform',
                        'transition-all',
                        'duration-500',
                        'ease-out',
                        'hover:scale-105',
                        'hover:shadow-2xl',
                        'opacity-0',
                        'translate-y-10',
                        'bg-white',
                        'p-6',
                        'text-center'
                    );

                    card.innerHTML = `
                <div class="absolute inset-0 bg-gradient-to-br ${achievement.gradient} opacity-10"></div>
                <div class="relative z-10">
                    <div class="mb-4 flex justify-center items-center">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br ${achievement.gradient} flex items-center justify-center shadow-lg">
                            <i data-feather="${achievement.icon}" class="text-white w-8 h-8"></i>
                        </div>
                    </div>
                    <div class="achievement-value text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-br ${achievement.gradient} mb-2" data-target="${achievement.value}">0+</div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-1">${achievement.label}</h3>
                    <p class="text-sm text-gray-600 opacity-75">${achievement.description}</p>
                </div>
            `;

                    card.style.transitionDelay = `${index * 300}ms`;
                    this.grid.appendChild(card);
                });
            }

            // Smooth counter animation with easing
            animateCounters() {
                const cards = document.querySelectorAll('.achievement-card');
                const counters = document.querySelectorAll('.achievement-value');

                cards.forEach((card, index) => {
                    // Immediately remove initial opacity and translation
                    card.classList.remove('opacity-0', 'translate-y-10');
                    card.classList.add('opacity-100', 'translate-y-0');
                });

                counters.forEach((counter, index) => {
                    const target = parseInt(counter.getAttribute('data-target'));
                    const duration = 5000; // Reduced duration for quicker animation
                    let startTimestamp = null;

                    const easeOutQuad = (t) => t * (2 - t);

                    const step = (timestamp) => {
                        if (!startTimestamp) startTimestamp = timestamp;
                        const progress = Math.min((timestamp - startTimestamp) / duration, 1);

                        const currentValue = Math.floor(easeOutQuad(progress) * target);
                        counter.textContent = `${currentValue}+`;

                        if (progress < 1) {
                            window.requestAnimationFrame(step);
                        } else {
                            counter.textContent = `${target}+`;
                        }
                    };

                    // Start animation immediately with minimal stagger
                    setTimeout(() => {
                        window.requestAnimationFrame(step);
                    }, index * 50); // Reduced stagger time
                });
            }

            // Intersection Observer for triggering animations
            setupIntersectionObserver() {
                const options = {
                    threshold: 0.1,
                };

                this.observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            // Trigger animation immediately with high priority
                            requestAnimationFrame(() => {
                                this.animateCounters();
                            });
                            this.observer.unobserve(entry.target);
                        }
                    });
                }, options);

                const achiev = document.querySelector('#achievementGrid');
                this.observer.observe(achiev);
            }

            // Initialize the entire rendering process
            init() {
                this.createAchievementCards();
                this.setupIntersectionObserver();
            }
        }

        // Initialize on DOM load
        document.addEventListener('DOMContentLoaded', () => {
            const renderer = new AchievementsRenderer(achievements, '#achievementGrid');
            renderer.init();

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