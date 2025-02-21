<!-- Navigation -->

<nav class="sticky top-0 bg-white shadow-md z-50">
    <div class="container mx-auto px-4 py-3 flex flex-col md:flex-row justify-between items-center align-center">
        <div class="w-full flex justify-between items-center mb-4 md:mb-0">
            <a href="<?php echo 'http://' . $_SERVER['HTTP_HOST']; ?>" class="flex items-center">
                <img src="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/uploads/malik-global1.png'; ?>" alt="Melek Global Consult Logo" class="h-12">
            </a>
            <button class="block md:hidden" onclick="toggleMobileMenu()">
                <i class="fas fa-bars text-blue-600" id="menu_hamburger"></i>
            </button>
        </div>
        
        <div id="mobileMenu" class="hidden md:block w-full md:w-auto">
            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-6 items-center justify-center md:justify-end">
                <a href="<?php echo 'http://' . $_SERVER['HTTP_HOST']; ?>" class="text-blue-600 hover:text-blue-800 font-semibold">Home</a>
                <a href="/student/" class="text-blue-600 hover:text-blue-800 font-semibold whitespace-nowrap">Apply Now</a>
                <a href="/services/" class="text-blue-600 hover:text-blue-800 font-semibold">Services</a>
                <a href="/about/" class="text-blue-600 hover:text-blue-800 font-semibold">About</a>
                <a href="/portfolio/" class="text-blue-600 hover:text-blue-800 font-semibold">Portfolio</a>
                <a href="/gallery/" class="text-blue-600 hover:text-blue-800 font-semibold">Gallery</a>
                <a href="/contact/" class="text-blue-600 hover:text-blue-800 font-semibold">Contact</a>
                <a href="/cooperate/" class="bg-blue-600 text-white px-7 py-2 rounded-full hover:bg-blue-700 transition whitespace-nowrap">Cooperate With Us</a>
            </div>
        </div>
    </div>
</nav>