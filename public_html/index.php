<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Melek Global Consult - Your Educational Journey Partner</title>
    <script src=""></script>
    <link rel="stylesheet" href="./imports/tailwind/tailwind.min.css">

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

    <?php require_once __DIR__ . '/components/nav.php'; ?>

    <?php require_once __DIR__ . '/components/hero.php'; ?>

    <?php require_once __DIR__ . '/components/achievement.php'; ?>

    <?php require_once __DIR__ . '/components/services.php'; ?>

    <!-- Testimonials -->
    <?php require_once __DIR__ . '/components/testimonials.php';?>
    
    <!-- Contact Us -->
    <?php require_once __DIR__ . '/components/contact-us.php';?>
        
    <!-- WhatsApp Float Icon -->
    <a href="https://wa.me/8618864506806"
        target="_blank"
        rel="noopener noreferrer"
        class="whatsapp-float">
        <div class="bg-green-500 text-white w-16 h-16 rounded-full flex items-center justify-center shadow-2xl pulse">
            <i class="fab fa-whatsapp text-4xl"></i>
        </div>
    </a>

    <?php require_once __DIR__ . '/components/footer.php'; ?>

    <script>
        document.querySelector("form").addEventListener("submit", function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            fetch("send-email.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                })
                .catch(error => {
                    console.error("Error:", error);
                });
        });

        document.getElementById('scheduleButton').addEventListener('click', function() {
            // Get form values
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const message = document.getElementById('message').value;

            // Check if all fields are filled
            if (!name || !email || !message) {
                alert('Please fill in all fields before submitting.');
                return;
            }

            // Create the WhatsApp message
            const whatsappMessage = encodeURIComponent(`Name: ${name}\nEmail: ${email}\nMessage: ${message}`);

            // WhatsApp API link with the message
            const whatsappLink = `https://wa.me/8618864506806?text=${whatsappMessage}`;

            // Open WhatsApp with the message
            window.open(whatsappLink, '_blank');
        });
    </script>


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