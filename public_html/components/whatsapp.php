<style>
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

<!-- WhatsApp Float Icon -->
<a href="https://wa.me/8618864506806"
    target="_blank"
    rel="noopener noreferrer"
    class="whatsapp-float">
    <div class="bg-green-500 text-white w-16 h-16 rounded-full flex items-center justify-center shadow-2xl pulse">
        <i class="fab fa-whatsapp text-4xl"></i>
    </div>
</a>