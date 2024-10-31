<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Movie Review</title>
    <link rel="icon" href="../asset/foto/logoonema.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <link rel="stylesheet" href="https://unpkg.com/boxicons/css/boxicons.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        .dropdown-menu {
            background-color: white;
            border: 1px solid gray;
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 10;
            padding-top: 0.5rem;
            opacity: 0;
            max-height: 0;
            overflow: hidden;
            transition: opacity 0.5s ease-in-out, max-height 0.5s ease-in-out;
        }

        .dropdown-menu.show {
            display: block;
            opacity: 1;
            max-height: 200px;
        }


        .dropdown-menu a {
            font-weight: 500;
            color: black;
            display: block;
            padding: 0.5rem 1rem;
            text-decoration: none;
        }

        .dropdown-menu a:hover {
            background-color: #ddd;
        }

        .rotate-180 {
            transform: rotate(180deg);
        }

        .play-button {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .play-icon-container {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 50%;
            margin-right: 8px;
        }

        .play-icon-container i {
            font-size: 24px;
        }

        .video-duration {
            font-size: 14px;
        }

        .rounded-2xl {
            border-radius: 1rem;
        }

        .rounded-t-2xl {
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
        }

        .rounded-b-2xl {
            border-bottom-left-radius: 1rem;
            border-bottom-right-radius: 1rem;
        }

        .video-container {
            overflow: hidden;
            position: relative;
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
        }

        .absolute.top-0.left-0.m-2 {
            top: 0;
            left: 0;
            margin: 0.5rem;
        }

        .bg-black.bg-opacity-75.p-2 {
            background-color: rgba(0, 0, 0, 0.75);
            padding: 0.5rem;
            border-bottom-left-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
        }

        #popup-overlay {
            transform: translateY(-100%);
            transition: transform 0.5s ease;
            z-index: 1999;
        }

        #popup-overlay.active {
            transform: translateY(0);
        }

        #popup-overlay.closing {
            transform: translateY(-100%);
        }



        #loginModal {
            display: none;
        }

        @keyframes modalShow {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes modalHide {
            from {
                opacity: 1;
                transform: translateY(0);
            }

            to {
                opacity: 0;
                transform: translateY(-50px);
            }
        }

        #loginModal.show {
            animation: modalShow 0.3s ease-out forwards;
        }

        #loginModal.hide {
            animation: modalHide 0.3s ease-in forwards;
        }

        #sidebar {
            position: fixed;
            top: 80px;
            left: -250px;
            height: calc(100% - 80px);
            width: 250px;
            background-color: #333;
            transition: left 0.5s ease-in-out;
            z-index: 1000;
            border-radius: 0px 5px 5px 0px;
            overflow-y: auto;
        }

        #sidebar.visible {
            left: 0;
        }

        #main-content {
            transition: 0.5s ease-in-out;
        }

        #main-content.shifted {
            margin-left: 250px;
        }

        #main-content ul {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
            grid-gap: 1rem;
            padding-left: 1rem;
        }

        #main-content ul li {
            padding-right: 0.5rem;
        }

        header {
            height: 80px;
        }

        #akun-popup {
            z-index: 50;
        }

        #popup-form-overlay {
            display: none;
            align-items: center;
            justify-content: center;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
        }

        #popup-form-overlay .bg-white {
            position: relative;
        }

        @keyframes modalShow {
            from {
                opacity: 0;
                transform: scale(0.9) translateY(-50px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        @keyframes modalHide {
            from {
                opacity: 1;
                transform: scale(1) translateY(0);
            }

            to {
                opacity: 0;
                transform: scale(0.9) translateY(-50px);
            }
        }


        #info-modal.show {
            animation: infoModalShow 0.3s ease-out forwards;
        }

        #info-modal.hidden {
            animation: infoModalHide 0.3s ease-in forwards;
        }

        @keyframes fadeInScale {
            0% {
                opacity: 0;
                transform: scale(0.9);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .modal-show {
            animation: fadeInScale 0.3s ease-out forwards;
        }

        .fade-in {
            opacity: 0;
            animation: fadeIn 0.3s forwards;
        }

        .fade-out {
            opacity: 1;
            animation: fadeOut 0.3s forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            to {
                opacity: 0;
            }
        }

        .video-controls {
            position: absolute;
            bottom: 0;
            right: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(0, 0, 0, 0.7);
            padding: 0.5rem;
            border-radius: 0.5rem;
        }

        .video-controls.hidden {
            display: none;
        }

        .video-controls.show {
            display: flex;
        }

        .video-controls-icon {
            cursor: pointer;
        }

        .speed-control,
        .quality-control {
            background: transparent;
            color: white;
            border: none;
            font-size: 1rem;
            margin-left: 0.5rem;
        }

        .speed-control {
            display: inline-block;
        }

        .quality-control {
            display: inline-block;
        }

        .favorited {
            color: white;
        }

        .bx-like {
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .bx-like.liked {
            color: white;
        }


        .truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .suggestion-item {
            display: flex;
            align-items: center;
            padding: 8px;
        }

        .suggestion-item img {
            width: 40px;
            height: 60px;
            object-fit: cover;
            margin-right: 8px;
            border-radius: 4px;
        }

        .suggestion-item span {
            flex: 1;
            font-size: 14px;
        }


        #suggestions {
            max-height: 15rem;
            overflow-y: auto;
            border: 1px solid #ccc;
            border-radius: 0.375rem;
            background-color: #fff;
            z-index: 20;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            opacity: 0;
            animation: fadeIn 0.3s ease forwards;
            transition: opacity 0.3s ease;
        }

        #suggestions.hidden {
            opacity: 0;
            animation: none;
        }


        #suggestions.show {
            opacity: 1;
            transform: translateY(0);
            animation: fadeIn 0.3s ease;
        }

        #suggestions a {
            cursor: pointer;
            text-decoration: none;
            display: block;
            padding: 0.5rem 1rem;
        }

        #suggestions a:hover {
            background-color: #f0f0f0;
        }

        @keyframes zoomIn {
            from {
                transform: scale(0.9);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .zoom-in {
            animation: zoomIn 0.3s ease;
        }


        @keyframes backgroundTransition {
            from {
                background-color: rgba(255, 255, 0, 0.3);
            }

            to {
                background-color: transparent;
            }
        }

        .background-transition {
            animation: backgroundTransition 0.5s ease-out;
        }

        .transition-transform {
            transition: transform 0.3s ease-in-out;
        }

        .play-button1 {
            position: relative;
            bottom: 25%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 1;
            transition: transform 0.3s ease;
        }


        .text-content {
            position: absolute;
            bottom: 0%;
            left: 25%;
            opacity: 1;
            transition: opacity 0.3s ease, transform 0.5s ease-in-out;
        }

        .slide:hover .play-button {
            transform: scale(1.1);
        }

        .slide video {
            transition: filter 0.3s ease-in-out;
            width: 100%;
            height: auto;
        }

        .slide:hover video {
            filter: brightness(0.4);
        }

        .slide:hover .text-content {
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .slide::before {
            content: "";
            position: relative;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0));
            opacity: 0;
            transition: opacity 0.3s ease, transform 0.5s ease;
            transform: translateY(-100%);
            z-index: 2;
        }

        .slide:hover::before {
            opacity: 1;
            transform: translateY(0);
        }


        .slide:hover .text-content-center {
            opacity: 1;
            transform: translate(-50%, -50%);
        }

        .slides {
            display: flex;
            transition: transform 0.5s ease;
            gap: 0;
        }

        .slide {
            width: 100%;
            flex-shrink: 0;
            overflow: hidden;
            position: relative;
            transition: all 0.5s ease-in-out;
        }

        .text-content-center {
            position: absolute;
            top: -20%;
            left: 55%;
            transform: translate(-50%, -50%);
            opacity: 0;
            color: white;
            text-align: left;
            transition: opacity 0.5s ease, transform 0.3s ease;
        }

        .play-button-container {
            position: absolute;
            bottom: 10%;
            left: 95%;
        }

        .controls {
            position: absolute;
            top: 45%;
            transform: translateY(-50%);
            width: 100%;
            display: flex;
            justify-content: space-between;
            pointer-events: none;
        }

        .control-button {
            background: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 10px;
            cursor: pointer;
            transition: background 0.3s ease;
            pointer-events: auto;
            border-radius: 5px 5px 5px 5px;
        }

        .control-button:active {
            animation: bubble 0.3s ease;
        }

        @keyframes bubble {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.3);
            }

            100% {
                transform: scale(1);
            }
        }


        .play-icon-small {
            width: 24px;
            height: 24px;
        }

        .play-icon-small i {
            font-size: 12px;
        }

        @layer utilities {
            .mask-gradient {
                mask-image: linear-gradient(to top, rgba(0, 0, 0, 0) 40%, rgba(0, 0, 0, 1) 0%);
                -webkit-mask-image: linear-gradient(to top, rgba(0, 0, 0, 0) 15%, rgba(0, 0, 0, 1) 50%);
            }

            .text-shadow-md {
                text-shadow: 0px 4px 20px rgba(0, 0, 0, 0.7);
            }
        }

        .shadow-custom {
            box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.45), 0 4px 10px rgba(0, 0, 0, 0.45);
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            background-color: white;
            transform: scale(1.05);
            opacity: 0;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .modal-content.show {
            transform: scale(1);
            opacity: 1;
        }

        .bookmark-icon {
            color: rgba(255, 255, 255, 0.5);
            transition: color 0.3s ease;
        }

        .bookmark-icon.active {
            color: rgba(255, 255, 255, 1);
        }


        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes modalFadeOut {
            from {
                opacity: 1;
                transform: scale(1);
            }

            to {
                opacity: 0;
                transform: scale(0.95);
            }
        }

        .modal-show {
            animation: modalFadeIn 0.3s forwards;
        }

        .modal-hide {
            animation: modalFadeOut 0.3s forwards;
        }

        #notificationModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            justify-content: center;
            align-items: center;
            z-index: 50;
        }

        #notificationModal.active {
            display: flex;
        }

        #notificationModal .modal-content {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        #historyModal {
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            z-index: 1500;
        }

        #historyModal:not(.hidden) {
            opacity: 1;
        }

        #historyModal::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: -1;
            pointer-events: none;
        }

        #historyModal .relative {
            position: relative;
            z-index: 10;
            pointer-events: auto;
        }

        #overlayBlocker {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 40;
            pointer-events: auto;
        }

        .modal-content {
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .modal-show {
            opacity: 1;
            transform: scale(1);
        }

        .modal-hide {
            opacity: 0;
            transform: scale(0.95);
        }
    </style>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</head>

<body class="font-poppins">
    <!--header-->
    <header class="bg-[#E52B09] sticky top-0 z-50">
        <div class="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a class="block text-teal-600" href="#">
                        <span class="sr-only">Home</span>
                        <img src="../asset/foto/logoonema.png" alt="Logo" class="w-20 h-20">
                    </a>
                </div>

                <div class="hidden md:flex items-center flex-grow ml-4">
                    <div class="relative flex items-center max-w-full w-full">
                        <button id="dropdownButton" class="relative bg-gray-300 px-4 text-sm font-medium text-gray-700 rounded-l-md flex items-center h-full py-2" style="padding-top: 9px; padding-bottom: 9px;">
                            All
                            <i id="dropdownArrow" class='bx bx-chevron-down h-4 w-4 ml-2 transition-transform duration-300'></i>
                        </button>

                        <div id="dropdownMenu" class="dropdown-menu rounded-md shadow-lg hidden absolute mt-2 bg-white">
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100"><i class='bx bx-search-alt-2'></i> All</a>
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100"><i class='bx bxs-detail'></i> Titles</a>
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100"><i class='bx bx-tv'></i> TV Episodes</a>
                        </div>

                        <div class="relative flex-1 flex items-center">
                            <input id="search-input" type="text" class="pl-10 pr-12 py-2 text-sm border rounded-r-md h-full w-full" placeholder="Search..." />
                            <i class='bx bx-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 font-2xl'></i>

                            <div id="suggestions" class="absolute top-full left-0 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg hidden z-50">

                            </div>

                            <div id="search-history" class="absolute top-full left-0 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg hidden z-50">

                            </div>
                        </div>

                        <div class="flex items-center ml-4">
                            <a id="menu-link" href="#" class="flex items-center transition duration-150 ease-in-out inset-0 hover:bg-black bg-opacity-10 hover:bg-opacity-10 hover:shadow-md rounded-md p-1">
                                <i class='bx bx-menu text-black font-bold' style="font-size: 30px;"></i>
                                <span class="text-white font-semibold text-sm ml-2">Menu</span>
                            </a>
                            <div class="h-6 border-l border-gray-400 mx-2"></div>
                            <a href="{{ route('watchlists') }}" class="flex items-center transition duration-150 ease-in-out inset-0 hover:bg-black bg-opacity-10 hover:bg-opacity-10 hover:shadow-md rounded-md p-2">
                                <i class='bx bxs-bookmark-star text-white font-bold' style="font-size: 24px;"></i>
                                <span class="text-white font-semibold text-sm ml-2">Watchlist</span>
                            </a>
                        </div>

                        <div class="flex items-center ml-4">
                            @guest
                            <a class="buy p-2 font-semibold text-sm bg-red-600 text-white rounded" href="{{ route('login') }}">Login</a>
                            @else
                            <form id="logout-form" action="{{ route('actionLogout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <a class="buy p-2 font-semibold text-sm bg-red-600 text-white rounded" href="{{ route('actionLogout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            @endguest
                        </div>

                        @auth
                        <div class="navbar flex items-center ml-4">
                            <a id="settings-icon" href="#" class="flex items-center">
                                <i class='bx bxs-category text-white' style="font-size: 24px;"></i>
                            </a>
                        </div>
                        <div class="profile flex items-center ml-4">
                            <img src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : 'https://static.vecteezy.com/system/resources/thumbnails/005/129/844/small_2x/profile-user-icon-isolated-on-white-background-eps10-free-vector.jpg' }}"
                                alt="Profile Photo"
                                class="w-8 h-8 rounded-full">
                            <span id="account-link" class="text-white cursor-pointer font-semibold text-sm ml-2">
                                {{ optional(Auth::user())->username }}
                            </span>
                        </div>


                        @endauth

                    </div>
                    <div class="block md:hidden">
                        <button class="rounded bg-gray-100 p-2 text-gray-600 transition hover:text-gray-600/75">
                            <i class='bx bx-menu h-5 w-5'></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!--end header-->

    <!--info -->
    <div id="info-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-4xl"> <!-- Ubah max-w-lg menjadi max-w-4xl -->
            <div class="flex p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">Persyaratan untuk ulasan film:</span>
                    <ul class="mt-1.5 list-disc list-inside">
                        <li>Minimal 10 karakter untuk ulasan.</li>
                        <li>Setidaknya satu karakter huruf kecil.</li>
                        <li>Termasuk satu karakter khusus, misalnya ! @ # ?</li>
                    </ul>
                </div>
            </div>
            <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Peringatan</span>
                <div>
                    <span class="font-medium">Perhatikan bahwa:</span>
                    <ul class="mt-1.5 list-disc list-inside">
                        <li>Ulasan yang tidak memenuhi syarat tidak akan dipublikasikan.</li>
                        <li>Pastikan untuk tidak menggunakan bahasa yang kasar atau tidak pantas.</li>
                        <li>Ulasan harus relevan dengan film yang diulas.</li>
                    </ul>
                </div>
            </div>

            <!-- Bagian Ulasan Film -->
            <div class="mt-4 text-justify">
                <h3 class="text-lg font-bold text-red-500">Ulasan Film</h3>
                <p class="mt-2 text-gray-400">
                    Tolong luangkan waktu sejenak untuk memberikan rating yang jujur dan konstruktif setelah menonton video trailer ini, karena setiap pendapat Anda sangat berarti dan dapat membantu pengguna lain dalam menentukan pilihan yang tepat sesuai dengan preferensi mereka. Dengan memberikan penilaian yang sesuai,
                    Anda berperan dalam menciptakan lingkungan yang informatif dan membantu orang lain menemukan konten yang benar-benar mereka nikmati, sehingga pengalaman menonton menjadi lebih menyenangkan dan bermanfaat." </p>
                <p class="mt-2 text-gray-400">
                    "Selain itu, kami sangat menghargai partisipasi Anda dalam komunitas kami, karena setiap rating tidak hanya mempengaruhi konten yang ditampilkan, tetapi juga memberikan masukan berharga bagi kami untuk terus meningkatkan kualitas layanan yang kami tawarkan.
                    Dengan berbagi pendapat dan pengalaman Anda, Anda turut berkontribusi dalam pengembangan platform ini, menjadikannya tempat yang lebih baik bagi semua pengguna yang mencari informasi dan hiburan yang berkualitas."
                </p>
            </div>

            <button id="close-info-modal" class="mt-4 bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Mengerti
            </button>
        </div>
    </div>
    <!--end info -->

    <!-- Modal Tambah form -->
    <div id="popup-form-overlay" class="fixed inset-0 hidden bg-gray-900 bg-opacity-50 flex justify-center items-center" style="z-index: 1999;">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-[40%] max-h-[70%] w-full mx-4 relative overflow-y-auto">
            <button id="close-popup-form" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <p class="text-gray-800 text-lg font-bold mb-4">Masukkan video</p>
            <form class="w-full" action="{{ route('form.action') }}" method="post" enctype="multipart/form-data">
                @csrf
                <!-- Judul Film -->
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-title">
                            Judul Film
                        </label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-title" type="text" placeholder="Contoh Film" name="gridTitle">
                        <p class="text-gray-600 text-xs italic">Masukkan judul film</p>
                    </div>
                </div>

                <!-- Deskripsi Video -->
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-description">
                            Deskripsi Video
                        </label>
                        <textarea class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-description" placeholder="Masukkan deskripsi video" name="gridDeskripsi"></textarea>
                        <p class="text-gray-600 text-xs italic">Masukkan deskripsi singkat tentang video</p>
                    </div>
                </div>

                <!-- Unggah Video -->
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="video-upload">
                            Unggah Video
                        </label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="video-upload" type="file" accept="video/*" name="gridVidio">
                        <p class="text-gray-600 text-xs italic">Pilih file video untuk diunggah</p>
                    </div>
                </div>

                <!-- Unggah Poster/Thumbnail -->
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="poster-upload">
                            Unggah Poster
                        </label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="poster-upload" type="file" accept="image/*" name="gridPoster">
                        <p class="text-gray-600 text-xs italic">Pilih file gambar untuk poster atau thumbnail</p>
                    </div>
                </div>

                <!-- Unggah Thumbnail -->
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="thumbnail-upload">
                            Unggah Thumbnail
                        </label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="thumbnail-upload" type="file" accept="image/*" name="gridThumbnail">
                        <p class="text-gray-600 text-xs italic">Pilih file gambar untuk thumbnail</p>
                    </div>
                </div>


                <!-- Tahun Rilis, Genre, dan Tombol Kirim -->
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-release-year">
                            Tahun Rilis
                        </label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-release-year" type="text" placeholder="2024" name="gridTahun">
                    </div>
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-popularity">
                            Genre
                        </label>
                        <div class="relative">
                            <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-popularity" name="gridOpsi">
                                <option>Horor</option>
                                <option>Komedi</option>
                                <option>Drama</option>
                                <option>Action</option>
                                <option>Fantasi</option>
                                <option>Thriller</option>
                                <option>Family</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="submit-button">
                            Kirim
                        </label>
                        <button class="appearance-none block font-semibold w-full bg-blue-500 text-white border border-blue-500 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-blue-700 focus:border-blue-700" id="submit-button" type="submit">
                            Kirim
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--end modal form-->

    <!-- Akun -->
    <div id="akun-popup" class="hidden fixed inset-0 bg-gray-800 bg-opacity-70 flex items-center justify-center transition-opacity duration-300 opacity-0" style="z-index: 1999;">
        <div id="akun-popup-content" class="transform transition-transform duration-300 scale-95 bg-white max-w-md rounded-lg overflow-hidden shadow-lg relative">
            <button id="close-akun-popup" class="absolute top-2 right-2 p-2 text-gray-500 hover:text-gray-900 focus:outline-none">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close</span>
            </button>

            <div class="text-center p-6 border-b">
                <div class="relative w-24 h-24 mx-auto">
                    <!-- Gambar Profil -->
                    <img class="h-24 w-24 rounded-full mx-auto border-2 border-gray-300 shadow-md object-cover"
                        src="{{ Auth::check() && Auth::user()->profile_photo_path 
         ? asset('storage/' . Auth::user()->profile_photo_path) 
         : 'https://static.vecteezy.com/system/resources/thumbnails/005/129/844/small_2x/profile-user-icon-isolated-on-white-background-eps10-free-vector.jpg' }}"
                        alt="Profile Photo" />

                    @if(Auth::check())
                    <form action="{{ route('update-profile-photo') }}" method="POST" enctype="multipart/form-data" class="absolute bottom-0 right-0">
                        @csrf
                        <label for="profile-photo" class="cursor-pointer">
                            <img class="h-8 w-8 rounded-full border border-gray-200" src="https://img.icons8.com/ios/50/000000/add-image.png" alt="Upload" />
                        </label>
                        <input type="file" name="profile_photo" id="profile-photo" class="hidden" onchange="this.form.submit()">
                    </form>
                    @endif
                </div>

                @if(Auth::check())
                <p class="pt-3 text-lg font-semibold">{{ Auth::user()->username }}</p>
                <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>

                @if(Auth::user()->profile_photo_path)
                <form action="{{ route('delete-profile-photo') }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white py-1 px-3 rounded-md hover:bg-red-600 transition duration-200">
                        Hapus Foto Profil
                    </button>
                </form>
                @endif
                @else
                <p class="pt-3 text-lg font-semibold">Guest</p>
                <p class="text-sm text-gray-600">Please log in to see your account details.</p>
                @endif


                @if(session('success'))
                <div class="mt-4 p-2 text-sm text-green-700 bg-green-100 border border-green-400 rounded">
                    {{ session('success') }}
                </div>
                @endif

                @if($errors->any())
                <div class="mt-4 p-2 text-sm text-red-700 bg-red-100 border border-red-400 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                        @if ($errors->has('profile_photo'))
                        <li>Foto profil tidak boleh melebihi 2MB.</li>
                        @endif
                    </ul>
                </div>
                @endif

                <!-- Daftar Akun -->
                <div class="mt-5">
                    <p class="font-semibold">Switch Account:</p>
                    <ul class="space-y-2">
                        @foreach($availableAccounts as $account)
                        <li>
                            <form action="{{ route('switch-account', $account->id) }}" method="POST">
                                @csrf
                                <div class="flex items-center justify-between p-2 bg-gray-100 rounded-md hover:bg-gray-200 transition duration-200">
                                    <div class="flex items-center">
                                        <img class="h-8 w-8 rounded-full mr-2"
                                            src="{{ $account->profile_photo_path 
                                                 ? asset('storage/' . $account->profile_photo_path) 
                                                 : 'https://static.vecteezy.com/system/resources/thumbnails/005/129/844/small_2x/profile-user-icon-isolated-on-white-background-eps10-free-vector.jpg' }}"
                                            alt="Profile Photo" />
                                        <span class="text-gray-800">{{ $account->username }} ({{ $account->email }})</span>
                                    </div>
                                    <button type="submit" class="text-blue-500 font-semibold hover:underline focus:outline-none">
                                        Switch
                                    </button>
                                </div>
                            </form>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="border-b">
                <div class="px-6 py-4 text-center">
                    @if(Auth::check())
                    <a href="#" class="border rounded py-2 px-4 text-xs font-semibold text-gray-700 hover:bg-gray-200 transition duration-200">Sign out of all accounts</a>
                    @else
                    <a href="{{ route('login') }}" class="border rounded py-2 px-4 text-xs font-semibold text-gray-700 hover:bg-gray-200 transition duration-200">Login to Manage Accounts</a>
                    @endif
                </div>
            </div>

            <div class="px-6 py-4">
                <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold text-gray-600 mr-2 hover:bg-gray-100 transition duration-200">Privacy Policy</span>
                <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold text-gray-600 mr-2 hover:bg-gray-100 transition duration-200">Terms of Service</span>
            </div>
        </div>
    </div>
    <!-- end Akun -->

    <!-- Modal Settings -->
    <div id="settings-modal" class="fixed inset-0 hidden z-50 flex items-center justify-center overflow-y-auto bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg dark:bg-gray-800 p-4 max-w-lg w-full">
            <div class="flex justify-between items-center pb-2 border-b">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Settings</h3>
                <button id="close-modal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="pt-4">
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Pilih Bahasa:</label>
                    <select id="language-select" class="w-full p-2 rounded-lg border dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="id" {{ app()->getLocale() == 'id' ? 'selected' : '' }}>Bahasa Indonesia</option>
                        <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Pilih Tema:</label>
                    <select id="theme-select" class="w-full p-2 rounded-lg border dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="light">Putih</option>
                        <option value="dark">Hitam</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end pt-4">
                <button id="close-modal-button" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Simpan</button>
            </div>
        </div>
    </div>
    <!-- end setting -->

    <!---pop up-->
    <div id="popup-overlay" class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-60 flex justify-center items-center z-50 overflow-hidden">
        <div class="bg-[#363434] p-8 rounded-lg w-full h-full relative flex flex-col">
            <i id="close-popup" class='bx bx-x absolute top-4 right-4 cursor-pointer text-white bg-red-500 rounded-full p-2 w-10 h-10 flex items-center justify-center'></i>
            <div class="grid grid-cols-2 grid-rows-2 gap-4 h-full overflow-auto">
                <div class="flex justify-center items-center p-2">
                    <img src="../asset/foto/logo_onema-removebg(1).png" alt="" class="w-64 h-64 object-cover">
                </div>
                <div class="flex flex-col justify-between p-4">
                    <div class="flex flex-col space-y-4">
                        <div class="flex space-x-4 mt-80">
                            <i class='bx bx-film text-red-500 text-3xl'></i>
                            <div>
                                <h3 class="text-lg font-bold text-gray-300 pb-5">Movie Review</h3>
                                <p class="text-sm text-gray-400 font-semibold pb-5">
                                    Latest Reviews <br> <br>
                                    Top Rated Movies <br> <br>
                                    Most Popular Reviews
                                </p>
                            </div>
                        </div>
                        <div class="flex space-x-4">
                            <i class='bx bx-film text-red-500 text-3xl'></i>
                            <div>
                                <h3 class="text-lg font-bold text-gray-300 pb-5">Movie Review</h3>
                                <p class="text-sm text-gray-400 font-semibold">
                                    Latest Reviews <br> <br>
                                    Top Rated Movies <br> <br>
                                    Most Popular Reviews
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col justify-between p-4 -mt-25">
                    <div class="flex space-x-4">
                        <i class='bx bx-film text-red-500 text-3xl'></i>
                        <div>
                            <h3 class="text-lg font-bold text-gray-300 pb-5">Movie Review</h3>
                            <p class="text-sm text-gray-400 font-semibold pb-2">
                                Latest Reviews <br> <br>
                                Top Rated Movies <br> <br>
                                Most Popular Reviews
                            </p>
                        </div>
                    </div>
                    <div class="flex space-x-4">
                        <i class='bx bx-tv text-red-500 text-3xl'></i>
                        <div>
                            <h3 class="text-lg font-bold text-gray-300 pb-5">TV Show</h3>
                            <p class="text-sm text-gray-400 font-semibold">
                                Latest Episodes <br> <br>
                                Top Rated Shows <br> <br>
                                Most Popular Shows
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end pop up-->

    <!-- side bar -->
    <aside id="sidebar" class="sidebar-hidden fixed top-0 left-0 z-40 w-64 h-screen">
        <div class="h-full px-3 py-4 overflow-y-auto bg-[#363434]" style="overflow:hidden;">
            <ul class="space-y-2 font-medium">
                <li>
                    @csrf
                    <a href="#" id="akun-link" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <!-- Foto Profil di Sebelah Kiri (Ukuran lebih besar) -->
                        <img class="h-14 w-14 rounded-full mr-2 object-cover"
                            src="{{ auth()->check() && auth()->user()->profile_photo_path 
           ? asset('storage/' . auth()->user()->profile_photo_path) 
           : 'https://static.vecteezy.com/system/resources/thumbnails/005/129/844/small_2x/profile-user-icon-isolated-on-white-background-eps10-free-vector.jpg' }}"
                            alt="Profile Photo" />

                        <span class="flex-1 text-sm ms-2 whitespace-nowrap">
                            {{ auth()->check() ? auth()->user()->username : 'Guest' }}
                        </span>

                        <i class='bx bx-dots-vertical-rounded bx-rotate-90 text-lg text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white -ml-2'></i>
                    </a>
                </li>

                <li>
                    <hr class="border-t border-gray-500 w-full mx-0 my-2">

                    <span class="block px-2 py-1 text-sm font-semibold text-[#FFFFFF] dark:text-[#FFFFFF]">
                        GENERAL
                    </span>
                </li>

                <li>
                    <a href="#" id="watchlist-link" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6 2l12 4v12l-12-4V2Zm1 2v7.5l8 2.5V4.5l-8-2.5ZM4 8v11l12 4v-2l-10-3.333V7.667L4 8Zm2 3.5V19l10 3v-3.5l-8-2.5V11.5Z" />
                        </svg>
                        <span class="ms-3 text-sm">My Collection</span>
                    </a>
                </li>
                <li>
                    <a href="#" id="historyButton" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12 3.5a8.5 8.5 0 1 0 8.5 8.5A8.5 8.5 0 0 0 12 3.5ZM2 12A10 10 0 1 1 12 22 10 10 0 0 1 2 12Zm10.25-.75V7a.75.75 0 1 0-1.5 0v5a.75.75 0 0 0 .75.75h4a.75.75 0 0 0 0-1.5Z" />
                            <path d="M7.75 4.75a.75.75 0 0 0-1.06 1.06l1.5 1.5a.75.75 0 0 0 1.06-1.06Z" />
                        </svg>
                        <span class="ms-3 text-sm">History</span>
                    </a>
                </li>
                <li>
                    <a href="#" id="notificationBtn" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 24a2.62 2.62 0 0 0 2.623-2.623h-5.246A2.623 2.623 0 0 0 12 24Zm10.407-6.24c-.77-.91-2.186-2.287-2.186-6.647 0-3.395-2.202-6.25-5.313-7.063V3.5a2.908 2.908 0 0 0-5.816 0v.55c-3.111.813-5.313 3.668-5.313 7.063 0 4.36-1.417 5.737-2.186 6.647A1.069 1.069 0 0 0 2.824 19.5h18.352a1.07 1.07 0 0 0 .825-1.74Z" />
                        </svg>
                        <span class="ms-3 text-sm">Notification</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M15 14c2.761 0 5-1.239 5-3v-.5C20 9.14 18.373 8 15 8s-5 1.14-5 2.5V11c0 1.761 2.239 3 5 3Zm0 2c-2.608 0-8 1.308-8 4v1h16v-1c0-2.692-5.392-4-8-4ZM9 10c0-1.329.368-2.036 1.151-2.58.748-.521 1.842-.669 3.087-.739-.137-2.247-1.165-3.681-4.238-3.681C6.373 3 4 5.36 4 8.16V9.5C4 10.761 6.239 12 9 12v-2Zm-1 1.974c-2.455 0-5 .729-5 2.383V16h5.303c.011-.4.044-.792.103-1.176-1.189-.55-2.26-1.133-2.406-1.85Z" />
                        </svg>
                        <span class="ms-3 text-sm">Friends</span>
                    </a>

                </li>
                <li>
                    <a href="#" id="settings-link" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                            <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                            <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                        </svg>
                        <span class="ms-3 text-sm">Settings</span>
                    </a>
                </li>
                <li>
                    <hr class="border-t border-gray-500 w-full mx-0 my-2">
                    <span class="block px-2 py-1 text-sm font-semibold text-[#FFFFFF] dark:text-[#FFFFFF]">MISCELLANEOUS</span>
                </li>
                <li>
                    <a href="#" id="info-link" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0C5.383 0 0 5.383 0 12s5.383 12 12 12 12-5.383 12-12S18.617 0 12 0zm0 22C6.486 22 2 17.514 2 12S6.486 2 12 2s10 4.486 10 10-4.486 10-10 10z" />
                            <path d="M11 10h2v7h-2zm0-4h2v2h-2z" />
                        </svg>
                        <span class="ms-3 text-sm">Info</span>
                    </a>
                </li>
                <li>
                    <hr class="border-t border-gray-500 w-full mx-0 my-2">
                    <span class="block px-2 py-1 text-sm font-semibold text-[#FFFFFF] dark:text-[#FFFFFF]">ADMIN PANEL</span>
                </li>
                <li>
                    <a href="#" id="tambah-link" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path d="M12 5v14m7-7H5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span class="ms-3 text-sm">Tambah</span>
                        <span class="inline-flex items-center justify-center px-2 ml-3 text-sm font-medium text-gray-800 bg-gray-200 rounded-full dark:bg-gray-700 dark:text-gray-300">opsional</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M15 14c2.761 0 5-1.239 5-3v-.5C20 9.14 18.373 8 15 8s-5 1.14-5 2.5V11c0 1.761 2.239 3 5 3Zm0 2c-2.608 0-8 1.308-8 4v1h16v-1c0-2.692-5.392-4-8-4ZM9 10c0-1.329.368-2.036 1.151-2.58.748-.521 1.842-.669 3.087-.739-.137-2.247-1.165-3.681-4.238-3.681C6.373 3 4 5.36 4 8.16V9.5C4 10.761 6.239 12 9 12v-2Zm-1 1.974c-2.455 0-5 .729-5 2.383V16h5.303c.011-.4.044-.792.103-1.176-1.189-.55-2.26-1.133-2.406-1.85Z" />
                        </svg>
                        <span class="ms-3 text-sm">tambah info</span>
                    </a>

                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                            <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                            <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                        </svg>
                        <span class="ms-3 text-sm">Lainnya</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
    <!--end side bar -->

    <!-- Modal History -->
    <div id="historyModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300 ease-in-out">
        <div class="relative w-auto max-w-4xl p-6 bg-gray-900 rounded-lg shadow-lg transform transition-transform duration-300 ease-in-out scale-95 opacity-0">
            <button id="closeModal" class="absolute top-3 right-3 text-white text-xl hover:text-red-400 transition duration-200">
                &times;
            </button>

            <div class="sticky top-0 bg-gray-900 z-10">
                <div class="flex justify-end -mb-10 pr-1">
                    <select id="sortOrder" class="p-2 text-sm bg-gray-800 text-white border border-gray-600 rounded">
                        <option value="newest">Terbaru</option>
                        <option value="oldest">Terlama</option>
                    </select>
                </div>
                <h3 class="text-3xl text-white font-bold mb-0.5 border-b-2 border-red-600 pb-4">History</h3>
            </div>


            <div id="historyContainer" class="overflow-y-auto max-h-96 pr-2" style="scrollbar-width: thin; scrollbar-color: #4b5563 #1f2937;">
            </div>
        </div>
    </div>
    <!-- Overlay -->
    <div id="overlayBlocker" class="hidden fixed inset-0 bg-black opacity-50"></div>

    <!-- modal notificatiom -->
    <div id="notificationModal" class="fixed inset-0 hidden z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>

            <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:align-middle sm:max-w-lg sm:w-full">
                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="w-6 h-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h1m0-4h-1m7-1h-7a5 5 0 00-5 5v7a5 5 0 005 5h7a5 5 0 005-5v-7a5 5 0 00-5-5z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Notification</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    You have new notifications!
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="closeModalBtn" class="inline-flex justify-center px-4 py-2 text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- end modal notificatiom -->

    <!-- Modal watchlist -->
    <div id="watchlistModal" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-gray-800 bg-opacity-50 transition-opacity duration-500 ease-in-out">
        <div class="modal-content relative p-4 w-full max-w-2xl h-full md:h-auto opacity-0 transform scale-95 transition-transform duration-500 ease-in-out">
            <div class="relative bg-white rounded-lg shadow">
                <div class="flex justify-between items-center p-5 rounded-t border-b">
                    <h3 class="text-xl font-medium text-gray-900">My Collection</h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-watchlist-hide="watchlistModal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <div class="p-5 border-b">
                    <input id="modalWatchlistSearch" type="text" placeholder="Search trailer in modal..." class="w-full p-2 border border-gray-300 rounded">
                </div>
                <div class="p-6 space-y-6">
                    <div id="modal-watchlist-content">
                        <ul id="modalWatchlistItems" class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                            @php $hasTrailer = false; @endphp

                            @forelse ($watchlistItems as $item)
                            @if($item->trailer)
                            @php $hasTrailer = true; @endphp
                            <li class="watchlist-item transition-transform duration-300 ease-in-out" data-title="{{ strtolower($item->trailer->title) }}">
                                <a href="{{ route('home.detail', $item->trailer->id) }}" class="group block overflow-hidden">
                                    <img src="{{ asset('upload/' . $item->trailer->poster) }}" alt="{{ $item->trailer->title }}" class="h-[150px] w-full object-cover transition duration-500 group-hover:scale-105 sm:h-[150px]" />
                                    <div class="relative bg-white pt-3">
                                        <h3 class="text-xs text-gray-700 group-hover:underline group-hover:underline-offset-4">{{ $item->trailer->title }}</h3>
                                    </div>
                                </a>
                            </li>
                            @endif
                            @empty
                            <li>
                                <p class="text-center text-gray-500">Your watchlist is empty.</p>
                            </li>
                            @endforelse

                            @if (!$hasTrailer)
                            <li>
                                <p class="text-center text-gray-500">Trailer not found.</p>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End modal watchlist -->

    <!--home-->
    <div id="main-content">
        <div class="flex flex-col lg:flex-row my-8 px-4">
            <div class="flex flex-col lg:flex-row my-8 px-4 lg:px-32">
                <div class="relative w-full lg:w-3/4 lg:mr-16 h-[500px] cursor-pointer overflow-hidden">
                    <div class="slider h-full">
                        <div class="slides h-full flex">
                            @foreach ($slider as $item)
                            <div class="slide relative h-full flex-shrink-0 w-full">
                                <a href="{{ route('home.detail', $item->id) }}">
                                    <video poster="{{ asset('upload/' . $item->thumbnail) }}" class="w-full h-full object-cover rounded-lg shadow-lg mask-gradient" style="image-rendering: crisp-edges;">
                                        <source src="{{ asset('upload/' . $item->vidio) }}" type="video/mp4">
                                    </video>
                                </a>

                                <div class="absolute bottom-10 left-0 w-full flex items-center px-8">
                                    <div class="poster-container h-[200px] w-[140px] flex-shrink-0 mr-6 relative">
                                        <a href="{{ route('home.detail', $item->id) }}">
                                            <img src="{{ asset('upload/' . $item->poster) }}" alt="Poster" class="w-full h-full object-cover rounded-md shadow-lg" /> </a>
                                        <div class="absolute -top-1" style="left: -0.45rem;">
                                            <div class="relative">
                                                <i class='bx bxs-bookmark text-gray-500 text-4xl'></i>
                                                <i class='bx bx-plus absolute top-1 text-white text-2xl' style="left: 5px;"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-content flex items-center">
                                        <a href="{{ route('home.detail', $item->id) }}">
                                            <button class="play-button bg-red-600 text-white rounded-full w-14 h-14 flex items-center justify-center mr-4 ">
                                                <i class='bx bx-play text-2xl'></i>
                                            </button>
                                        </a>

                                        <div class="info-content flex flex-col">
                                            <h2 class="text-4xl font-extrabold text-slate-900 mb-2 text-shadow-md">{{ $item->title }}</h2>
                                            <p class="text-base text-black mb-4 text-shadow-md">{{ Str::limit($item->deskripsi, 30, '...') }}</p>
                                            <div class="video-duration text-slate-600 font-bold" id="slider-duration-{{ $loop->index }}"></div>
                                        </div>
                                    </div>

                                    <div class="text-content-center">
                                        <a href="{{ route('home.detail', $item->id) }}">
                                            <button class="play-button1 bg-red-600 text-white rounded-full w-14 h-14 flex items-center justify-center top-14 -left-20 transform transition-transform duration-300 hover:scale-125">
                                                <i class='bx bx-play text-2xl'></i>
                                            </button>

                                        </a>
                                        <h2 class="text-4xl font-extrabold">{{ $item->title }}</h2>
                                        <p>{{ Str::limit($item->deskripsi, 30, '...') }}</p>
                                    </div>


                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="controls">
                            <button class="control-button" id="prevSlide">&#10094;</button>
                            <button class="control-button" id="nextSlide">&#10095;</button>
                        </div>
                    </div>
                </div>



                <!-- Recommendations Section -->
                <div class="w-full lg:w-1/3 lg:mt-0 flex flex-col ml-4 lg:ml-8 bg-black bg-opacity-75 rounded-lg p-4 shadow-lg shadow-black">
                    <h1 class="text-black text-xl font-bold mb-4 px-4 py-2 rounded-lg">
                        <span class="border-l-4 border-red-600 pl-2 text-white">{{ __('Recommended Movies') }}</span>
                    </h1>

                    <section class="flex flex-col space-y-4 mt-4">
                        @foreach ($recommendations as $recommendation)
                        <div class="flex bg-black bg-opacity-75 rounded-md overflow-hidden h-28 w-full max-w-xs shadow-custom relative">
                            <div class="flex-shrink-0 w-1/4">
                                <a href="{{ route('home.detail', $recommendation->id) }}">
                                    <video width="100%" height="100%" poster="{{ asset('upload/' . $recommendation->poster) }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                                        <source src="{{ asset('upload/' . $recommendation->vidio) }}" type="video/mp4">
                                    </video>
                                </a>
                            </div>

                            <div class="flex-1 p-2 flex flex-col justify-center">
                                <div class="flex items-center justify-start mb-2">
                                    <a href="{{ route('home.detail', $recommendation->id) }}" class="play-button flex items-center mr-1">
                                        <div class="play-icon-container play-icon-small">
                                            <i class="fas fa-play text-white text-lg"></i>
                                        </div>
                                    </a>
                                    <div class="video-duration font-bold text-white px-2 py-1 rounded" id="recommendation-duration-{{ $loop->index }}"></div>
                                </div>

                                <h3 class="text-sm font-semibold text-white truncate mt-1">{{ $recommendation->title }}</h3>
                                <p class="text-xs text-white mt-1">{{ Str::limit($recommendation->deskripsi, 50) }}</p>
                            </div>
                        </div>
                        @endforeach
                    </section>
                </div>

            </div>
        </div>

        <!-- Top Onema This Week Section -->
        <div class="px-32 my-8">
            <h1 class="text-black text-xl font-bold px-0 py-2 mb-6 inline-block rounded-r-lg ml-6">
                <span class="border-l-4 border-red-700 pl-2">Top Onema</span>
            </h1>
            <div id="no-results-message" class="hidden text-center text-red-500 font-semibold my-6">
                Tidak ditemukan
            </div>
            <section>
                <ul class="mt-8 grid grid-flow-row-dense gap-4 sm:grid-cols-3 lg:grid-cols-6">
                    @foreach ($topOnema as $trailers)
                    <li class="p-2 overflow-hidden relative text-white"
                        data-title="{{ $trailers->title }}"
                        data-poster="{{ asset('upload/' . $trailers->poster) }}"
                        data-trailer-id="{{ $trailers->id }}">

                        <!-- Konten trailer lainnya -->
                        <div class="video-container rounded-t-lg overflow-hidden" id="video-container-{{ $loop->index }}">
                            <a href="{{ route('home.detail', $trailers->id) }}">
                                <video width="100%" height="250" poster="{{ asset('upload/' . $trailers->poster) }}"
                                    class="video h-[250px] w-full object-cover transition duration-500 group-hover:scale-105 sm:h-[290px]"
                                    id="video-gladiator-{{ $loop->index }}">
                                    <source id="video-source-{{ $loop->index }}" src="{{ asset('upload/' . $trailers->vidio) }}" type="video/mp4">
                                </video>
                            </a>

                            <div class="absolute -top-2 -left-3.5 flex items-center justify-center">
                                <i class='bx bxs-bookmark-star text-gray-700 text-6xl {{ $trailers->watchlists->where('user_id', auth()->id())->count() ? 'text-red-700' : '' }} bookmark-icon'></i>
                                @if($trailers->watchlists->where('user_id', auth()->id())->count())
                                <i class='bx bxs-check-circle text-white absolute text-2xl check-icon' style="top: 10px;"></i>
                                @else
                                <i class='bx bx-plus text-white absolute text-2xl plus-icon' style="top: 10px;"></i>
                                @endif
                            </div>


                            <div class="absolute bottom-0 left-0 m-2 play-button">
                                <div class="play-icon-container">
                                    <i class='bx bx-play text-white'></i>
                                </div>
                                <div class="video-duration text-white font-bold" id="duration-{{ $loop->index }}"></div>
                                <div class="video-controls hidden">
                                    <div class="video-controls-icon">
                                        <i class='bx bx-dots-horizontal-rounded text-white text-2xl'></i>
                                    </div>
                                    <div class="current-time text-white font-bold" id="current-time-{{ $loop->index }}"></div>
                                </div>
                                <div class="current-time text-white font-bold" id="current-time-{{ $loop->index }}"></div>
                            </div>
                        </div>

                        <div class="bg-black bg-opacity-75 p-2 rounded-b-lg">
                            <!-- Rating stars -->
                            <div class="flex items-center text-white text-xs mb-2"> 
                                <svg class="w-4 h-4 text-yellow-300 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                </svg>

                                <p class="average-rating ms-1">{{ number_format($trailers->averageRating(), 2) }}</p>
                            </div>

                            <h3 class="text-sm">Official trailer</h3>
                            <h3 class="text-lg mt-1 font-semibold mb-2 truncate">{{ $trailers->title }}</h3>

                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium">{{ $trailers->populer }} | {{ $trailers->tahun }}</span>
                            </div>

                            <div class="flex items-center mt-4 mb-5">
                                <i class='bx bx-like mr-2 cursor-pointer' id="like-{{ $loop->index }}"></i>
                                <span id="like-count-{{ $loop->index }}">{{ $trailers->likes_count }}</span>
                                <i class='bx bx-dislike ml-4 mr-2 cursor-pointer' id="dislike-{{ $loop->index }}"></i>
                                <span id="dislike-count-{{ $loop->index }}">{{ $trailers->dislikes_count }}</span>
                                <i class="bx bxs-bookmark-star cursor-pointer px-2 {{ $trailers->watchlists->where('user_id', auth()->id())->count() ? 'text-red-700' : '' }}"></i>
                            </div>
                        </div>

                    </li>
                    @endforeach
                </ul>
            </section>
        </div>

    </div>
    <!--end home-->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Popup menu
            const menuLink = document.getElementById('menu-link');
            const popupOverlay = document.getElementById('popup-overlay');
            const closePopupButton = document.getElementById('close-popup');
            const body = document.querySelector('body');

            if (menuLink) {
                menuLink.addEventListener('click', function(event) {
                    event.preventDefault();
                    popupOverlay.classList.add('active');
                    body.classList.add('overflow-hidden');
                });
            }

            if (closePopupButton) {
                closePopupButton.addEventListener('click', function() {
                    popupOverlay.classList.add('closing');
                    setTimeout(function() {
                        popupOverlay.classList.remove('active', 'closing');
                        body.classList.remove('overflow-hidden');
                    }, 500);
                });
            }

            //modal notification
            document.getElementById('notificationBtn').addEventListener('click', function(event) {
                event.preventDefault();
                document.getElementById('notificationModal').classList.add('active');
            });

            document.getElementById('closeModalBtn').addEventListener('click', function() {
                document.getElementById('notificationModal').classList.remove('active');
            });

            // Mendapatkan elemen yang diperlukan
            const watchlistLink = document.getElementById('watchlist-link');
            const watchlistModal = document.getElementById('watchlistModal');
            const watchlistCloseButton = watchlistModal.querySelector('[data-watchlist-hide="watchlistModal"]');
            const modalContent = watchlistModal.querySelector('.modal-content');
            const modalWatchlistSearch = document.getElementById('modalWatchlistSearch');
            const modalWatchlistItems = document.getElementById('modalWatchlistItems');

            function showWatchlistModal() {
                watchlistModal.classList.remove('hidden');
                setTimeout(() => {
                    modalContent.classList.add('modal-show');
                    modalContent.classList.remove('modal-hide');
                }, 10);
            }

            function hideWatchlistModal() {
                modalContent.classList.add('modal-hide');
                modalContent.classList.remove('modal-show');
                setTimeout(() => {
                    watchlistModal.classList.add('hidden');
                }, 500);
            }

            watchlistLink.addEventListener('click', function(event) {
                event.preventDefault();
                showWatchlistModal();
            });

            watchlistCloseButton.addEventListener('click', function() {
                hideWatchlistModal();
            });

            window.addEventListener('click', function(event) {
                if (event.target === watchlistModal) {
                    hideWatchlistModal();
                }
            });

            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    hideWatchlistModal();
                }
            });

            modalWatchlistSearch.addEventListener('input', function() {
                const searchTerm = modalWatchlistSearch.value.toLowerCase();
                const items = modalWatchlistItems.querySelectorAll('.watchlist-item');
                items.forEach(item => {
                    const title = item.getAttribute('data-title');
                    if (title.includes(searchTerm)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });



            //modal history
            const historyButton = document.getElementById('historyButton');
            const historyModal = document.getElementById('historyModal');
            const closeModalButton = document.getElementById('closeModal');
            const overlayBlocker = document.getElementById('overlayBlocker');
            const historyContainer = document.getElementById('historyContainer');
            const sortOrderSelect = document.getElementById('sortOrder');

            function renderHistory(savedHistory) {
                historyContainer.innerHTML = '';

                savedHistory.forEach(function(item, index) {
                    let date = new Date(item.timestamp);
                    let formattedDate = `${date.toLocaleDateString()} ${date.toLocaleTimeString()}`;

                    let historyItem = `
            <div class="history-item flex mb-4 p-4 bg-gray-800 rounded-lg">
                <img src="${item.poster}" alt="Poster Image" class="rounded-lg w-32 h-48 object-cover mr-4">
                <div class="flex flex-col justify-between">
                    <div>
                        <p class="text-xl text-white font-bold">${item.title}</p>
                        <p class="text-sm text-gray-400">${item.genre}</p>
                        <p class="text-sm text-gray-400">${item.year}</p>
                    </div>
                    <div class="flex justify-between items-center">
                        <p class="text-sm text-gray-500">${formattedDate}</p>
                        <button class="deleteHistoryButton text-red-500 pl-5" data-index="${index}">Hapus</button>
                    </div>
                </div>
            </div>
        `;

                    historyContainer.innerHTML += historyItem;
                });

                const deleteButtons = document.querySelectorAll('.deleteHistoryButton');
                deleteButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const index = this.getAttribute('data-index');
                        savedHistory.splice(index, 1);
                        localStorage.setItem('videoHistory', JSON.stringify(savedHistory));
                        renderHistory(savedHistory);
                    });
                });
            }

            historyButton.addEventListener('click', function(event) {
                event.preventDefault();

                let savedHistory = JSON.parse(localStorage.getItem('videoHistory')) || [];

                sortOrderSelect.addEventListener('change', function() {
                    if (this.value === 'newest') {
                        savedHistory.sort((a, b) => b.timestamp - a.timestamp);
                    } else {
                        savedHistory.sort((a, b) => a.timestamp - b.timestamp);
                    }
                    renderHistory(savedHistory);
                });

                renderHistory(savedHistory);

                historyModal.classList.remove('hidden');
                overlayBlocker.classList.remove('hidden');
                setTimeout(() => {
                    historyModal.querySelector('.relative').classList.remove('scale-95', 'opacity-0');
                    historyModal.querySelector('.relative').classList.add('scale-100', 'opacity-100');
                }, 10);
            });

            closeModalButton.addEventListener('click', function() {
                historyModal.querySelector('.relative').classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    historyModal.classList.add('hidden');
                    overlayBlocker.classList.add('hidden');
                }, 300);
            });

            window.addEventListener('click', function(event) {
                if (event.target === overlayBlocker) {
                    historyModal.querySelector('.relative').classList.add('scale-95', 'opacity-0');
                    setTimeout(() => {
                        historyModal.classList.add('hidden');
                        overlayBlocker.classList.add('hidden');
                    }, 300);
                }
            });



            //watchlist
            $(document).ready(function() {
                $('.bxs-bookmark-star').on('click', function() {
                    var trailerId = $(this).closest('li').data('trailer-id');
                    var bookmarkIcon = $(this);

                    $.ajax({
                        url: '/trailer/' + trailerId + '/bookmark',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            if (response.status === 'added') {
                                bookmarkIcon.addClass('text-red-700');
                            } else {
                                bookmarkIcon.removeClass('text-red-700');
                            }

                            location.reload();
                        }
                    });
                });
            });

            //recomended movies
            document.getElementById('nextSlide').addEventListener('click', function() {
                fetchRecommendations();
            });

            document.getElementById('prevSlide').addEventListener('click', function() {
                fetchRecommendations();
            });

            function fetchRecommendations() {
                fetch('/api/recommendations')
                    .then(response => response.json())
                    .then(data => {
                        const recommendationsSection = document.querySelector('section.flex.flex-col.space-y-4.mt-4');
                        recommendationsSection.innerHTML = '';

                        data.forEach(item => {
                            recommendationsSection.innerHTML += `
                <div class="flex bg-black bg-opacity-75 rounded-md overflow-hidden h-28 w-full max-w-xs">
                    <div class="flex-shrink-0 w-1/4 relative">
                        <a href="/home/detail/${item.id}">
                            <video width="100%" height="100%" poster="/upload/${item.poster}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                                <source src="/upload/${item.vidio}" type="video/mp4">
                            </video>
                        </a>
                        <div class="absolute top-0 left-0 m-2">
                            <i class='bx bxs-bookmark-star text-white text-xl'></i>
                        </div>
                        <a href="/home/detail/${item.id}" class="absolute bottom-0 left-0 m-2 play-button">
                            <div class="play-icon-container play-icon-small">
                                <i class="fas fa-play text-white"></i>
                            </div>
                        </a>
                        <div class="video-duration font-bold absolute bottom-0 right-0 m-2">${item.duration}</div>
                    </div>
                    <div class="flex-1 p-2 flex flex-col justify-center">
                        <h3 class="text-sm font-semibold text-white truncate">${item.title}</h3>
                        <p class="text-xs text-white mt-1">${item.deskripsi.substring(0, 50)}...</p>
                    </div>
                </div>
                `;
                        });
                    })
                    .catch(error => console.error('Error fetching recommendations:', error));
            }


            // Video Duration
            const sliderImages = document.querySelectorAll('.slider img');
            const recommendationVideos = document.querySelectorAll('.flex.flex-col.space-y-4 video');

            function formatDuration(duration) {
                const minutes = Math.floor(duration / 60);
                const seconds = Math.floor(duration % 60);
                return `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            }

            function updateSliderDuration(video, index) {
                video.addEventListener('loadedmetadata', function() {
                    const duration = formatDuration(video.duration);
                    const durationElement = document.getElementById(`slider-duration-${index}`);
                    if (durationElement) {
                        durationElement.textContent = duration;
                    }
                });
            }

            function updateRecommendationDuration(video, index) {
                video.addEventListener('loadedmetadata', function() {
                    const duration = formatDuration(video.duration);
                    const durationElement = document.getElementById(`recommendation-duration-${index}`);
                    if (durationElement) {
                        durationElement.textContent = duration;
                    }
                });
            }

            document.querySelectorAll('.slides video').forEach((video, index) => {
                updateSliderDuration(video, index);
            });
            recommendationVideos.forEach((video, index) => {
                updateRecommendationDuration(video, index);
            });





            //slider
            const slides = document.querySelector('.slides');
            const slideCount = document.querySelectorAll('.slide').length;
            let currentIndex = 0;
            let autoSlideInterval;
            let isDragging = false;
            let startPos = 0;
            let isDraggingAction = false;

            function updateSlidePosition() {
                slides.style.transform = `translateX(-${currentIndex * 100}%)`;
            }

            function startAutoSlide() {
                autoSlideInterval = setInterval(() => {
                    document.getElementById('nextSlide').click();
                }, 8000);
            }

            function resetAutoSlide() {
                clearInterval(autoSlideInterval);
                startAutoSlide();
            }

            document.getElementById('nextSlide').addEventListener('click', () => {
                if (currentIndex < slideCount - 1) {
                    currentIndex++;
                } else {
                    currentIndex = 0;
                }
                updateSlidePosition();
                resetAutoSlide();
            });

            document.getElementById('prevSlide').addEventListener('click', () => {
                if (currentIndex > 0) {
                    currentIndex--;
                } else {
                    currentIndex = slideCount - 1;
                }
                updateSlidePosition();
                resetAutoSlide();
            });

            document.querySelector('.slider').addEventListener('mousedown', (event) => {
                event.preventDefault();

                isDragging = true;
                isDraggingAction = false;
                startPos = event.clientX;

                document.addEventListener('mousemove', onDrag);
                document.addEventListener('mouseup', onDragEnd);
            });

            function onDrag(event) {
                if (!isDragging) return;

                const currentPos = event.clientX;
                const movedBy = currentPos - startPos;

                if (Math.abs(movedBy) > 50) {
                    isDraggingAction = true;
                }

                if (movedBy < -100 && currentIndex < slideCount - 1) {
                    currentIndex++;
                    updateSlidePosition();
                    isDragging = false;
                } else if (movedBy > 100 && currentIndex > 0) {
                    currentIndex--;
                    updateSlidePosition();
                    isDragging = false;
                }
            }

            function onDragEnd() {
                isDragging = false;
                document.removeEventListener('mousemove', onDrag);
                document.removeEventListener('mouseup', onDragEnd);
                resetAutoSlide();
            }

            document.querySelectorAll('.slide a').forEach(anchor => {
                anchor.addEventListener('click', function(event) {
                    if (isDraggingAction) {
                        event.preventDefault();
                    }
                });
            });

            startAutoSlide();

            // Search
            const searchInput = document.getElementById('search-input');
            const suggestions = document.getElementById('suggestions');
            const searchHistoryContainer = document.getElementById('search-history');
            const searchContainer = document.querySelector('.relative.flex-1');

            let searchHistory = JSON.parse(localStorage.getItem('searchHistory')) || [];

            searchInput.addEventListener('input', function() {
                const searchQuery = this.value.toLowerCase();

                if (searchQuery) {
                    searchHistoryContainer.classList.add('hidden');
                    updateSuggestions(searchQuery);
                } else {
                    if (searchHistory.length > 0) {
                        updateSearchHistory();
                    }
                    suggestions.classList.add('hidden');
                }
            });

            searchInput.addEventListener('focus', function() {
                if (searchHistory.length > 0) {
                    updateSearchHistory();
                }
            });

            document.addEventListener('click', function(e) {
                if (!searchContainer.contains(e.target)) {
                    searchHistoryContainer.classList.add('hidden');
                    suggestions.classList.add('hidden');
                }
            });

            // Update saran pencarian berdasarkan input
            function updateSuggestions(query) {
                suggestions.innerHTML = '';

                if (query) {
                    suggestions.classList.remove('hidden');

                    const trailers = document.querySelectorAll('li[data-title]');
                    const addedTitles = [];

                    trailers.forEach(function(trailer) {
                        const title = trailer.getAttribute('data-title').toLowerCase();

                        if (title.includes(query) && !addedTitles.includes(title)) {
                            const suggestionItem = document.createElement('a');
                            suggestionItem.href = '#';
                            suggestionItem.className = 'suggestion-item hover:bg-gray-100 p-2 block';

                            const titleText = document.createElement('span');
                            titleText.textContent = trailer.getAttribute('data-title');
                            suggestionItem.appendChild(titleText);

                            suggestionItem.addEventListener('click', function(e) {
                                e.preventDefault();
                                searchInput.value = trailer.getAttribute('data-title');
                                performSearch(searchInput.value);
                                suggestions.classList.add('hidden');
                            });

                            suggestions.appendChild(suggestionItem);

                            addedTitles.push(title);
                        }
                    });

                    if (suggestions.innerHTML === '') {
                        suggestions.classList.add('hidden');
                    }
                } else {
                    suggestions.classList.add('hidden');
                }
            }

            // Fungsi pencarian
            function performSearch(query) {
                const trailers = document.querySelectorAll('li[data-title]');
                let found = false;

                trailers.forEach(function(trailer) {
                    const title = trailer.getAttribute('data-title').toLowerCase();
                    if (title.includes(query.toLowerCase())) {
                        trailer.classList.remove('hidden');
                        found = true;
                    } else {
                        trailer.classList.add('hidden');
                    }
                });

                const topOnemaSection = document.querySelector('.px-32');
                if (topOnemaSection) {
                    topOnemaSection.scrollIntoView({
                        behavior: 'smooth'
                    });
                }

                const noResultsMessage = document.getElementById('no-results-message');
                if (!found) {
                    noResultsMessage.classList.remove('hidden');
                } else {
                    noResultsMessage.classList.add('hidden');
                }
            }



            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const query = this.value;

                    if (query && !searchHistory.includes(query)) {
                        searchHistory.unshift(query); 
                        localStorage.setItem('searchHistory', JSON.stringify(searchHistory)); 
                        updateSearchHistory();
                    }

                    performSearch(query);
                }
            });

            function removeSearchHistory(index) {
                searchHistory.splice(index, 1);
                localStorage.setItem('searchHistory', JSON.stringify(searchHistory));
                updateSearchHistory();
            }

            function updateSearchHistory() {
                searchHistoryContainer.innerHTML = '';

                if (searchHistory.length === 0) {
                    searchHistoryContainer.classList.add('hidden');
                    return;
                }

                searchHistory.forEach(function(item, index) {
                    const historyItem = document.createElement('div');
                    historyItem.className = 'flex justify-between items-center p-2 cursor-pointer';

                    const historyText = document.createElement('span');
                    historyText.textContent = item;
                    historyItem.appendChild(historyText);

                    historyItem.addEventListener('click', function() {
                        searchInput.value = item;
                        performSearch(item);
                        searchHistoryContainer.classList.add('hidden');
                    });

                    const deleteButton = document.createElement('button');
                    deleteButton.innerHTML = "<i class='bx bx-x text-red-500 text-3xl'></i>";
                    deleteButton.className = 'ml-2 text-red-600 hover:underline';

                    deleteButton.addEventListener('click', function(e) {
                        e.stopPropagation();
                        removeSearchHistory(index);
                    });

                    historyItem.appendChild(deleteButton);
                    searchHistoryContainer.appendChild(historyItem);
                });

                searchHistoryContainer.classList.remove('hidden');
            }





            //tambah
            const addButton = document.querySelector('#tambah-link');
            const popupFormOverlay = document.getElementById('popup-form-overlay');
            const closePopupFormButton = document.getElementById('close-popup-form');

            function showModal() {
                popupFormOverlay.style.opacity = '0';
                popupFormOverlay.style.transform = 'scale(0.95)';
                popupFormOverlay.style.display = 'flex';

                setTimeout(() => {
                    popupFormOverlay.style.transition = 'opacity 0.3s ease-out, transform 0.3s ease-out';
                    popupFormOverlay.style.opacity = '1';
                    popupFormOverlay.style.transform = 'scale(1)';
                }, 10);
            }

            function hideModal() {
                popupFormOverlay.style.transition = 'opacity 0.3s ease-out, transform 0.3s ease-out';
                popupFormOverlay.style.opacity = '0';
                popupFormOverlay.style.transform = 'scale(0.95)';

                setTimeout(() => {
                    popupFormOverlay.style.display = 'none';
                }, 300);
            }

            if (addButton) {
                addButton.addEventListener('click', function(event) {
                    event.preventDefault();
                    showModal();
                });
            }

            if (closePopupFormButton) {
                closePopupFormButton.addEventListener('click', function() {
                    hideModal();
                });
            }

            window.addEventListener('click', function(event) {
                if (event.target === popupFormOverlay) {
                    hideModal();
                }
            });


            // Sign-in modal
            const loginModal = document.getElementById('loginModal');
            const signInButton = document.querySelector('button.bg-red-700');
            const closeModal = document.getElementById('closeModal');

            if (signInButton) {
                signInButton.addEventListener('click', () => {
                    loginModal.style.display = 'flex';
                });
            }

            if (closeModal) {
                closeModal.addEventListener('click', () => {
                    loginModal.style.display = 'none';
                });
            }

            window.addEventListener('click', (e) => {
                if (e.target === loginModal) {
                    loginModal.style.display = 'none';
                }
            });

            // Play video and display controls
            document.querySelectorAll('.play-button').forEach(button => {
                button.addEventListener('click', function() {
                    const videoContainer = this.closest('.video-container');
                    const video = videoContainer.querySelector('video');
                    video.play();
                    video.setAttribute('controls', 'controls');
                    videoContainer.querySelector('.play-button').style.display = 'none';
                    videoContainer.querySelector('.video-controls').classList.remove('hidden');
                });
            });

            document.querySelectorAll('.play-button').forEach(button => {
                button.addEventListener('click', function() {
                    const videoContainer = this.closest('.video-container');
                    const video = videoContainer.querySelector('video');
                    video.play();
                    video.setAttribute('controls', 'controls');
                    videoContainer.querySelector('.play-button').style.display = 'none';
                    videoContainer.querySelector('.video-controls').classList.remove('hidden');
                });
            });

            document.querySelectorAll('.video-controls-icon').forEach(icon => {
                icon.addEventListener('click', function() {
                    const videoControls = this.closest('.video-controls');
                    videoControls.classList.toggle('show');
                });
            });

            document.querySelectorAll('.speed-control').forEach(select => {
                select.addEventListener('change', function() {
                    const video = this.closest('.video-controls').previousElementSibling.querySelector('video');
                    video.playbackRate = parseFloat(this.value);
                });
            });



            // Dropdown menu with animation
            const dropdownButton = document.getElementById('dropdownButton');
            const dropdownMenu = document.getElementById('dropdownMenu');
            const dropdownArrow = document.getElementById('dropdownArrow');

            if (dropdownButton) {
                dropdownButton.addEventListener('click', function() {
                    dropdownMenu.classList.toggle('show');
                    dropdownArrow.classList.toggle('rotate-180');

                    if (dropdownMenu.classList.contains('show')) {
                        dropdownMenu.style.display = 'block';
                        setTimeout(() => {
                            dropdownMenu.style.opacity = 1;
                        }, 0);
                    } else {
                        dropdownMenu.style.opacity = 0;
                        setTimeout(() => {
                            dropdownMenu.style.display = 'none';
                        }, 300);
                    }
                });
            }

            document.addEventListener('click', function(event) {
                if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.classList.remove('show');
                    dropdownArrow.classList.remove('rotate-180');
                    dropdownMenu.style.opacity = 0;
                    setTimeout(() => {
                        dropdownMenu.style.display = 'none';
                    }, 300);
                }
            });

            // Sidebar
            const settingsIcon = document.getElementById('settings-icon');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');

            let scrollPosition = 0;

            function toggleSidebar() {
                if (sidebar.classList.contains('visible')) {
                    scrollPosition = window.scrollY;
                    sidebar.classList.remove('visible');
                    mainContent.classList.remove('shifted');
                    localStorage.setItem('sidebarVisible', 'false');

                    setTimeout(() => {
                        window.scrollTo(0, scrollPosition);
                    }, 0);
                } else {
                    scrollPosition = window.scrollY;
                    sidebar.classList.add('visible');
                    mainContent.classList.add('shifted');
                    localStorage.setItem('sidebarVisible', 'true');

                    setTimeout(() => {
                        window.scrollTo(0, scrollPosition);
                    }, 0);
                }
            }

            settingsIcon.addEventListener('click', toggleSidebar);

            const isSidebarVisible = localStorage.getItem('sidebarVisible') === 'true';
            if (isSidebarVisible) {
                sidebar.classList.add('visible');
                mainContent.classList.add('shifted');
            } else {
                sidebar.classList.remove('visible');
            }

            document.addEventListener('DOMContentLoaded', () => {
                if (isSidebarVisible) {
                    mainContent.classList.add('shifted');
                }
            });


            // Modal untuk "Info"
            const infoLink = document.getElementById('info-link');
            const infoModal = document.getElementById('info-modal');
            const closeInfoModal = document.getElementById('close-info-modal');

            if (infoLink && infoModal && closeInfoModal) {
                infoLink.addEventListener('click', function(event) {
                    event.preventDefault();
                    infoModal.classList.remove('hidden');
                    infoModal.classList.add('fade-in');
                });

                closeInfoModal.addEventListener('click', function() {
                    infoModal.classList.add('fade-out');
                    setTimeout(function() {
                        infoModal.classList.add('hidden');
                        infoModal.classList.remove('fade-in', 'fade-out');
                    }, 300);
                });

                window.addEventListener('click', function(event) {
                    if (event.target === infoModal) {
                        infoModal.classList.add('fade-out');
                        setTimeout(function() {
                            infoModal.classList.add('hidden');
                            infoModal.classList.remove('fade-in', 'fade-out');
                        }, 300);
                    }
                });
            }

            //akun
            const akunLink = document.getElementById('akun-link');
            const accountLink = document.getElementById('account-link');
            const akunPopup = document.getElementById('akun-popup');
            const akunPopupContent = document.getElementById('akun-popup-content');
            const closeAkunPopup = document.getElementById('close-akun-popup');

            function openAkunPopup() {
                akunPopup.classList.remove('hidden');
                setTimeout(() => {
                    akunPopup.classList.add('opacity-100');
                    akunPopup.classList.remove('opacity-0');
                    akunPopupContent.classList.add('scale-100');
                    akunPopupContent.classList.remove('scale-95');
                }, 10);
            }

            if (akunLink) {
                akunLink.addEventListener('click', function(event) {
                    event.preventDefault();
                    openAkunPopup();
                });
            }

            if (accountLink) {
                accountLink.addEventListener('click', function(event) {
                    event.preventDefault();
                    openAkunPopup();
                });
            }

            if (closeAkunPopup) {
                closeAkunPopup.addEventListener('click', function() {
                    akunPopup.classList.remove('opacity-100');
                    akunPopup.classList.add('opacity-0');
                    akunPopupContent.classList.remove('scale-100');
                    akunPopupContent.classList.add('scale-95');
                    setTimeout(() => {
                        akunPopup.classList.add('hidden');
                    }, 300);
                });
            }

            window.addEventListener('click', (e) => {
                if (e.target === akunPopup) {
                    akunPopup.classList.remove('opacity-100');
                    akunPopup.classList.add('opacity-0');
                    akunPopupContent.classList.remove('scale-100');
                    akunPopupContent.classList.add('scale-95');
                    setTimeout(() => {
                        akunPopup.classList.add('hidden');
                    }, 300);
                }
            });


            // Close dropdown alert
            const alertBox = document.getElementById('dropdown-cta');
            const isAlertClosed = localStorage.getItem('dropdownAlertClosed');

            if (!isAlertClosed) {
                alertBox.style.display = 'block';
            } else {
                alertBox.style.display = 'none';
            }

            const closeButton = document.querySelector('[data-dismiss-target="#dropdown-cta"]');

            if (closeButton && alertBox) {
                closeButton.addEventListener('click', function() {
                    alertBox.style.display = 'none';
                    localStorage.setItem('dropdownAlertClosed', 'true');
                });
            }


            // Settings modal (Bahasa dan Tema)
            const settingsLink = document.getElementById('settings-link');
            const settingsModal = document.getElementById('settings-modal');
            const closeSettingsModal = document.getElementById('close-modal');
            const closeSettingsButton = document.getElementById('close-modal-button');

            if (settingsLink) {
                settingsLink.addEventListener('click', function(event) {
                    event.preventDefault();
                    settingsModal.classList.remove('hidden');
                    settingsModal.classList.add('modal-show');
                });
            }

            if (closeSettingsModal) {
                closeSettingsModal.addEventListener('click', function() {
                    settingsModal.classList.add('hidden');
                    settingsModal.classList.remove('modal-show');
                });
            }

            if (closeSettingsButton) {
                closeSettingsButton.addEventListener('click', function() {
                    settingsModal.classList.add('hidden');
                    settingsModal.classList.remove('modal-show');
                });
            }

            document.getElementById('theme-select').addEventListener('change', function() {
                const theme = this.value;
                if (theme === 'dark') {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            });

            document.getElementById('language-select').addEventListener('change', function() {
                const language = this.value;
                if (language === 'english') {
                    changeLanguage('en');
                } else {
                    changeLanguage('id');
                }
            });

            function changeLanguage(lang) {
                fetch(`/lang/${lang}`)
                    .then(response => response.json())
                    .then(data => {
                        document.querySelector('h3').textContent = data.settings;
                        document.querySelector('label[for="language-select"]').textContent = data.select_language;
                        document.querySelector('label[for="theme-select"]').textContent = data.select_theme;
                        document.getElementById('close-modal-button').textContent = data.save;

                        document.querySelector('#language-select option[value="english"]').textContent = data.english;
                        document.querySelector('#language-select option[value="indo"]').textContent = data.indonesian;

                        document.querySelector('#theme-select option[value="light"]').textContent = data.light;
                        document.querySelector('#theme-select option[value="dark"]').textContent = data.dark;
                    });
            }


            document.getElementById('language-select').addEventListener('change', function() {
                const language = this.value;

                fetch('/change-language', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            lang: language
                        })
                    })
                    .then(response => {
                        if (response.ok) {
                            location.reload();
                        }
                    });
            });





            // Video controls only on play
            document.querySelectorAll('.play-button').forEach(button => {
                button.addEventListener('click', function() {
                    const videoContainer = this.closest('.video-container');
                    const video = videoContainer.querySelector('video');
                    video.play();
                    video.setAttribute('controls', 'controls');
                    videoContainer.querySelector('.play-button').style.display = 'none';
                    videoContainer.querySelector('.video-controls').classList.remove('hidden');
                });
            });

            // Set video duration
            document.querySelectorAll('video').forEach(video => {
                video.addEventListener('loadedmetadata', function() {
                    const duration = Math.floor(video.duration);
                    const minutes = Math.floor(duration / 60);
                    const seconds = duration % 60;
                    const formattedDuration = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
                    video.closest('.video-container').querySelector('.video-duration').textContent = formattedDuration;
                });
            });
        });
    </script>

</body>

</html>