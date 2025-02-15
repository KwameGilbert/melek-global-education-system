<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Melek Global Consult - Your Educational Journey Partner</title>
    <script src=""></script>
    <link rel="stylesheet" href="<?php __DIR__ . "/../imports/tailwind/tailwind.min.css";?>">

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