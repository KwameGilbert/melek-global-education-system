<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Gallery - Melek Global Consult</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 text-gray-900">
    <!-- Navigation -->
    <?php require_once __DIR__ . '/../components/nav.php'; ?>

    <!-- Hero Section -->
    <section class="bg-cover bg-center h-72" style="background-image: url('https://images.unsplash.com/photo-1505373877841-8d25f7d46678?auto=format&fit=crop&q=80');">
        <div class="bg-black bg-opacity-60 h-full flex items-center justify-center">
            <h1 class="text-white text-5xl font-bold">Gallery</h1>
        </div>
    </section>

    <!-- Main Content Container -->
    <main class="container mx-auto px-4 py-12 space-y-16" id="galleryContainer">
        <!-- Dynamic gallery sections will be injected here -->
    </main>

    <!-- Modal for Enlarged Image -->
    <div id="imageModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-75 hidden z-50" role="dialog" aria-modal="true">
        <div class="relative">
            <!-- Loading spinner shown until image loads -->
            <div id="loadingSpinner" class="absolute inset-0 flex items-center justify-center">
                <div class="w-12 h-12 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
            </div>
            <img id="modalImage" src="" alt="Enlarged view" class="max-w-full max-h-screen rounded shadow-lg object-contain" />
            <button id="closeModal" aria-label="Close modal" class="absolute top-2 right-2 text-white text-3xl bg-gray-800 bg-opacity-75 rounded-full w-10 h-10 flex items-center justify-center">&times;</button>
        </div>
    </div>

    <!-- JavaScript to load gallery images dynamically and enable modal view -->
    <script>
        <?php
        // Define the base gallery directory (adjust the path if needed)
        $galleryDir = __DIR__ . '/gallery';
        // Define the public base URL for gallery images (adjust as needed)
        $baseUrl = 'gallery';

        // Auto-detect all subdirectories (categories) in the gallery directory
        $allItems = scandir($galleryDir);
        $categories = array_filter($allItems, function ($item) use ($galleryDir) {
            return is_dir($galleryDir . '/' . $item) && !in_array($item, ['.', '..']);
        });

        // Initialize the gallery data array
        $galleryData = [];

        // Loop through each detected category and get image files
        foreach ($categories as $category) {
            $categoryPath = $galleryDir . '/' . $category;
            // Get image files (case-insensitive matching for common image extensions)
            $images = glob($categoryPath . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
            // Only add category if there are images available
            if (!empty($images)) {
                // Convert file paths to web-friendly URLs using the base URL and category name
                $webImages = array_map(function ($image) use ($category, $baseUrl) {
                    return $baseUrl . '/' . $category . '/' . basename($image);
                }, $images);
                // Format the category name (e.g. "conferences" → "Conferences")
                $categoryName = ucwords(str_replace('_', ' ', $category));
                $galleryData[$categoryName] = $webImages;
            }
        }
        ?>
        // Pass PHP array to JavaScript
        const galleryData = <?php echo json_encode($galleryData, JSON_PRETTY_PRINT); ?>;

        // Function to dynamically create gallery sections
        function loadGallery() {
            const container = document.getElementById('galleryContainer');

            // Create an introduction section
            const introSection = document.createElement('section');
            introSection.innerHTML = `
        <h2 class="text-3xl font-semibold text-center text-blue-600 mb-4">Our Conference & Event Highlights</h2>
        <p class="text-gray-700 leading-relaxed">
          Explore our gallery showcasing conferences, workshops, and other events that highlight our commitment to international collaboration and excellence.
        </p>
      `;
            container.appendChild(introSection);

            // Loop through each category and create a section for it
            for (const [category, images] of Object.entries(galleryData)) {
                // Create a section for the category
                const section = document.createElement('section');
                section.className = "mb-12";

                // Category title and grid container
                section.innerHTML = `
          <h2 class="text-3xl font-semibold text-center text-blue-600 mb-4">${category}</h2>
          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6" id="${category.replace(/\s+/g, '')}">
          </div>
        `;
                container.appendChild(section);

                // Populate the grid with images
                const grid = section.querySelector('div');
                if (images.length === 0) {
                    grid.innerHTML = `<p class="text-gray-500">No images available in this category.</p>`;
                } else {
                    images.forEach(imgSrc => {
                        const card = document.createElement('div');
                        card.className = "bg-white p-4 rounded shadow cursor-pointer";
                        card.innerHTML = `
              <img src="${imgSrc}" alt="${category} Image" class="w-full h-64 object-cover rounded">
           
            `;
                        // Open modal on image click
                        card.addEventListener('click', () => openModal(imgSrc));
                        grid.appendChild(card);
                    });
                }
            }
        }

        // Modal functionality
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        const closeModalBtn = document.getElementById('closeModal');
        const loadingSpinner = document.getElementById('loadingSpinner');

        function openModal(src) {
            // Show the spinner until the image loads
            loadingSpinner.classList.remove('hidden');
            modalImg.src = src;
            modal.classList.remove('hidden');
            // Set focus to the close button for accessibility
            closeModalBtn.focus();
        }

        // When the modal image loads, hide the spinner
        modalImg.addEventListener('load', () => {
            loadingSpinner.classList.add('hidden');
        });

        function closeModal() {
            modal.classList.add('hidden');
            modalImg.src = "";
        }

        closeModalBtn.addEventListener('click', closeModal);

        // Close modal when clicking outside the modal content
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });

        // Load gallery data once the document is ready
        document.addEventListener('DOMContentLoaded', loadGallery);

        
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

    <!-- Footer -->
    <?php require_once __DIR__ . '/../components/footer.php'; ?>
</body>

</html>