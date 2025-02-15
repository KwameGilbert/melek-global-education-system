<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Our Portfolio - Melek Global Consult</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900">
    <!-- Header -->
    <?php require_once __DIR__ . '/../components/nav.php' ?>

    <!-- Hero Section -->
    <section class="bg-cover bg-center h-72" style="background-image: url('https://via.placeholder.com/1200x500?text=Our+Portfolio');">
        <div class="bg-black bg-opacity-50 h-full flex items-center justify-center">
            <h1 class="text-white text-5xl font-bold">Our Portfolio</h1>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-12 space-y-16" id="portfolioContainer">
        <!-- The dynamic portfolio sections will be injected here by JavaScript -->
    </main>

    <!-- Modal for Enlarged Image -->
    <div id="imageModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-75 hidden">
        <div class="relative">
            <img id="modalImage" src="" alt="Enlarged view" class="max-w-full max-h-screen rounded shadow-lg">
            <button id="closeModal" class="absolute top-2 right-2 text-white text-3xl bg-gray-800 bg-opacity-75 rounded-full w-10 h-10 flex items-center justify-center">&times;</button>
        </div>
    </div>

    <!-- JavaScript to load portfolio images dynamically and enable modal view -->
    <script>
    <?php
        // Define the base portfolio directory
        $portfolioDir = __DIR__ . '/documents';
        
        // Categories to look for (matching folder names)
        $categories = ['scholarship', 'visa', 'others'];
        
        // Initialize the portfolio data array
        $portfolioData = [];
        
        // Loop through each category and get images
        foreach ($categories as $category) {
            $categoryPath = $portfolioDir . '/' . $category;
            
            if (is_dir($categoryPath)) {
                // Get all image files from the directory
                $images = glob($categoryPath . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
                
                // Convert file paths to web-friendly URLs and add to portfolio data
                $webImages = array_map(function($image) {
                    return 'portfolio/' . basename(dirname($image)) . '/' . basename($image);
                }, $images);
                
                // Add to portfolio data with proper category name
                $categoryName = ucwords(str_replace('_', ' ', $category));
                $portfolioData[$categoryName] = $webImages;
            }
        }
    ?>
    // Pass PHP array to JavaScript
    const portfolioData = <?php echo json_encode($portfolioData, JSON_PRETTY_PRINT); ?>;

        // Function to dynamically create portfolio sections
        function loadPortfolio() {
            const container = document.getElementById('portfolioContainer');

            // Create an introduction section
            const introSection = document.createElement('section');
            introSection.innerHTML = `
        <h2 class="text-3xl font-semibold mb-4">Showcasing Our Success</h2>
        <p class="text-gray-700 leading-relaxed">
          At Melek Global Consult, our portfolio reflects our proven track record in securing scholarships, visa approvals, and other important documents for our clients. All personal information has been blurred out to ensure our clients’ privacy while demonstrating our expertise.
        </p>
      `;
            container.appendChild(introSection);

            // Loop through each category and create a section for it
            for (const [category, images] of Object.entries(portfolioData)) {
                // Create a section for the category
                const section = document.createElement('section');
                section.className = "mb-12";

                // Category title and description (customize the description as needed)
                section.innerHTML = `
          <h2 class="text-3xl font-semibold mb-4">${category}</h2>
          <p class="text-gray-700 mb-6">
            Explore our successful cases in <strong>${category.toLowerCase()}</strong>.
          </p>
          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6" id="${category.replace(/\s+/g, '')}">
          </div>
        `;
                container.appendChild(section);

                // Populate the grid with images
                const grid = section.querySelector('div');
                images.forEach(imgSrc => {
                    const card = document.createElement('div');
                    card.className = "bg-white p-4 rounded shadow cursor-pointer";
                    card.innerHTML = `
            <img src="${imgSrc}" alt="${category} Document" class="w-full h-auto rounded">
            <p class="text-center mt-2 text-sm text-gray-500">Personal info blurred</p>
          `;
                    // When an image is clicked, open it in the modal
                    card.addEventListener('click', () => openModal(imgSrc));
                    grid.appendChild(card);
                });
            }
        }

        // Modal functionality
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        const closeModalBtn = document.getElementById('closeModal');

        function openModal(src) {
            modalImg.src = src;
            modal.classList.remove('hidden');
        }

        function closeModal() {
            modal.classList.add('hidden');
            modalImg.src = "";
        }

        closeModalBtn.addEventListener('click', closeModal);

        // Close modal when clicking outside the modal image
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });

        // Load portfolio data when the document is ready
        document.addEventListener('DOMContentLoaded', loadPortfolio);
    </script>

    <!-- Footer -->
    <?php require_once __DIR__ . '/../components/footer.php'; ?>
</body>

</html>