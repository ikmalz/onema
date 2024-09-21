<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Movie Review</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
            /* Adjust according to content */
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
            border-bottom-left-radius: 1rem;
            border-bottom-right-radius: 1rem;
        }

        #popup-overlay {
            visibility: hidden;
            opacity: 0;
            transform: scale(0.9);
            transition: opacity 0.3s ease, transform 0.3s ease, visibility 0s 0.3s;
        }

        #popup-overlay.active {
            visibility: visible;
            opacity: 1;
            transform: scale(1);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        /* Animasi keluar */
        #popup-overlay.closing {
            visibility: visible;
            opacity: 0;
            transform: scale(0.9);
            transition: opacity 0.3s ease, transform 0.3s ease, visibility 0s 0.3s;
        }

        #loginModal {
            display: none;
        }

        /* Animasi untuk modal */
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

        /* Styling modal untuk animasi */
        #loginModal.show {
            animation: modalShow 0.3s ease-out forwards;
        }

        #loginModal.hide {
            animation: modalHide 0.3s ease-in forwards;
        }

        /* Posisi Sidebar di bawah Header */
        #sidebar {
            position: fixed;
            top: 80px;
            left: -250px;
            height: calc(100% - 80px);
            width: 250px;
            background-color: #333;
            transition: left 0.5s ease-in-out;
            z-index: 1000;
            border-radius: 0px 15px 15px 0px;
            overflow-y: auto;
        }

        /* Sidebar terlihat */
        #sidebar.visible {
            left: 0;
        }

        /* Mengatur ulang grid video dan menggeser konten saat sidebar muncul */
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

        /* Tambahkan padding agar video tidak terlalu dekat dengan sidebar */
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

        /* Animasi modal Info */
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

        /* Animasi Fade-in dan Fade-out */
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

        .bx-like,
        .bx-bookmark,
        .bxs-bookmark {
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .bx-like.liked {
            color: white;
        }


        /* Pastikan ikon bookmark tetap konsisten dalam ukuran dan posisi */
        .bx-bookmark,
        .bxs-bookmark {
            display: inline-block;
            width: 24px;
            height: 24px;
            line-height: 24px;
            vertical-align: middle;
            text-align: center;
            transition: color 0.3s ease, transform 0.3s ease;
            /* Transisi halus untuk perubahan */
        }

        .truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Animasi untuk muncul */
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
            /* Mulai dengan opacity 0 */
            animation: fadeIn 0.3s ease forwards;
            /* Terapkan animasi */
            transition: opacity 0.3s ease;
            /* Transisi untuk perubahan opacity */
        }

        #suggestions.hidden {
            opacity: 0;
            /* Sembunyikan dengan opacity 0 */
            animation: none;
            /* Hentikan animasi saat tersembunyi */
        }


        #suggestions.show {
            opacity: 1;
            /* Opacity penuh saat ditampilkan */
            transform: translateY(0);
            /* Posisi normal saat ditampilkan */
            animation: fadeIn 0.3s ease;
            /* Terapkan animasi fade-in */
        }

        #suggestions a {
            cursor: pointer;
            text-decoration: none;
            display: block;
            padding: 0.5rem 1rem;
            /* Padding untuk item saran */
        }

        #suggestions a:hover {
            background-color: #f0f0f0;
        }

        /* Animasi untuk memperbesar video yang ditemukan */
        /* Animasi zoom-in */
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


        /* Animasi untuk transisi latar belakang */
        @keyframes backgroundTransition {
            from {
                background-color: rgba(255, 255, 0, 0.3);
                /* Warna latar belakang awal (kuning transparan) */
            }

            to {
                background-color: transparent;
                /* Latar belakang transparan setelah animasi */
            }
        }

        .background-transition {
            animation: backgroundTransition 0.5s ease-out;
        }

        .transition-transform {
            transition: transform 0.3s ease-in-out;
            /* waktu animasi dipercepat */
        }

        .slider-container {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .slider-item {
            min-width: 100%;
            transition: transform 0.5s ease;
        }

        .slider {
            position: relative;
            overflow: hidden;
        }

        .slides {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .slide {
            min-width: 100%;
            box-sizing: border-box;
        }

        .controls {
            position: absolute;
            top: 40%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
        }

        .control-button {
            background: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
            transition: transform 0.5s ease;
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
            /* Ukuran ikon lebih kecil */
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
    </style>
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

                        <!-- Kontainer Pencarian -->
                        <div class="relative flex-1 flex items-center">
                            <input id="search-input" type="text" class="pl-10 pr-12 py-2 text-sm border rounded-r-md h-full w-full" placeholder="Search..." />
                            <i class='bx bx-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 font-2xl'></i>

                            <!-- Kontainer Saran Pencarian -->
                            <div id="suggestions" class="absolute top-full left-0 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg hidden z-50">

                            </div>

                            <!-- Kontainer Riwayat Pencarian -->
                            <div id="search-history" class="absolute top-full left-0 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg hidden z-50">

                            </div>
                        </div>

                        <div class="flex items-center ml-4">
                            <a id="menu-link" href="#" class="flex items-center">
                                <i class='bx bx-menu text-black font-bold' style="font-size: 30px;"></i>
                                <span class="text-white font-semibold text-sm ml-2">Menu</span>
                            </a>
                            <div class="h-6 border-l border-gray-400 mx-2"></div>
                            <a href="{{ route('watchlist') }}" class="flex items-center">
                                <i class='bx bxs-bookmark-star text-white font-bold' style="font-size: 24px;"></i>
                                <span class="text-white font-semibold text-sm ml-2">Watchlist</span>
                            </a>

                        </div>

                        <!-- Kontainer Login/Logout -->
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

                        <!-- Kontainer Pengaturan dan Username -->
                        @auth
                        <div class="navbar flex items-center ml-4">
                            <a id="settings-icon" href="#" class="flex items-center">
                                <i class='bx bxs-category text-white' style="font-size: 24px;"></i>
                            </a>
                        </div>
                        <!-- Menggabungkan username dan profile photo dalam satu kelas -->
                        <div class="profile flex items-center ml-4">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRgwzioHdOQKqCkL_KxmDiVgATG4rtrjImg4w&s"
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
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-lg">
            <div class="flex p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">Ensure that these requirements are met:</span>
                    <ul class="mt-1.5 list-disc list-inside">
                        <li>At least 10 characters (and up to 100 characters)</li>
                        <li>At least one lowercase character</li>
                        <li>Inclusion of at least one special character, e.g., ! @ # ?</li>
                    </ul>
                </div>
            </div>
            <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Danger</span>
                <div>
                    <span class="font-medium">Ensure that these requirements are met:</span>
                    <ul class="mt-1.5 list-disc list-inside">
                        <li>At least 10 characters (and up to 100 characters)</li>
                        <li>At least one lowercase character</li>
                        <li>Inclusion of at least one special character, e.g., ! @ # ?</li>
                    </ul>
                </div>
            </div>
            <button id="close-info-modal" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                mengerti
            </button>
        </div>
    </div>
    <!--end info -->

    <!-- Modal Tambah form -->
    <div id="popup-form-overlay" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md mx-auto">
            <button id="close-popup-form" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>


            <p class="text-gray-800 text-lg font-bold mb-4">Masukkan video</p>
            <form class="w-full max-w-lg" action="{{ route('form.action') }}" method="post" enctype="multipart/form-data">
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
                            Unggah Poster/Thumbnail
                        </label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="poster-upload" type="file" accept="image/*" name="gridPoster">
                        <p class="text-gray-600 text-xs italic">Pilih file gambar untuk poster atau thumbnail</p>
                    </div>
                </div>
                <!-- Tahun Rilis, Popularitas, dan Tombol Kirim -->
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
    <div id="akun-popup" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center transition-opacity duration-300 opacity-0">
        <div id="akun-popup-content" class="transform transition-transform duration-300 scale-95 bg-white max-w-md rounded-lg overflow-hidden shadow-lg relative">
            <button id="close-akun-popup" class="absolute top-2 right-2 p-2 text-gray-500 hover:text-gray-900">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close</span>
            </button>
            <div class="text-center p-6 border-b">
                <div class="relative w-24 h-24 mx-auto">
                    <!-- Gambar Profil -->
                    <img class="h-24 w-24 rounded-full mx-auto" src="{{ Auth::user()->profile_photo_url ?? 'https://static.vecteezy.com/system/resources/thumbnails/005/129/844/small_2x/profile-user-icon-isolated-on-white-background-eps10-free-vector.jpg' }}" alt="" />

                    <!-- Ikon Tambah -->
                    <form action="" method="POST" enctype="multipart/form-data" class="absolute bottom-0 right-0">
                        @csrf
                        <label for="profile-photo" class="cursor-pointer">
                            <img class="h-8 w-8 rounded-full border border-gray-200" src="https://img.icons8.com/ios/50/000000/add-image.png" alt="Upload" />
                        </label>
                        <input type="file" name="profile_photo" id="profile-photo" class="hidden" onchange="this.form.submit()">
                    </form>
                </div>
                <p class="pt-2 text-lg font-semibold">{{ optional(Auth::user())->username }}</p>
                <p class="text-sm text-gray-600">{{ optional(Auth::user())->email }}</p>
                <div class="mt-5">
                    <a href="#" class="border rounded-full py-2 px-4 text-xs font-semibold text-gray-700">Manage your Google Account</a>
                </div>
            </div>

            <div class="border-b">
                <div class="px-6 py-4 text-center">
                    <a href="#" class="border rounded py-2 px-4 text-xs font-semibold text-gray-70">Sign out of all accounts</a>
                </div>
            </div>
            <div class="px-6 py-4">
                <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold text-gray-600 mr-2">Privacy Policy</span>
                <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold text-gray-600 mr-2">Terms of Service</span>
            </div>
        </div>
    </div>
    <!-- end Akun -->

    <!-- setting -->
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
                <!-- Language Selection -->
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Pilih Bahasa:</label>
                    <select id="language-select" class="w-full p-2 rounded-lg border dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="indo">Bahasa Indonesia</option>
                        <option value="english">English</option>
                    </select>
                </div>
                <!-- Theme Selection -->
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

    <!--modal login-->
    <div id="loginModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-gray-900 mx-auto pb-10">Sign in to your account</h2>
                <button id="closeModal" class="text-gray-600 hover:text-gray-900">&times;</button>
            </div>
            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-900">Username</label>
                    <input id="username" name="username" type="text" required class="block w-full border border-gray-300 rounded-md py-2 px-3 text-gray-900 focus:ring-indigo-500 focus:border-indigo-500" placeholder="your_username">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-900">Email address</label>
                    <input id="email" name="email" type="email" required class="block w-full border border-gray-300 rounded-md py-2 px-3 text-gray-900 focus:ring-indigo-500 focus:border-indigo-500" placeholder="you@example.com">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-900">Password</label>
                    <input id="password" name="password" type="password" required class="block w-full border border-gray-300 rounded-md py-2 px-3 text-gray-900 focus:ring-indigo-500 focus:border-indigo-500" placeholder="********">
                </div>
                <div>
                    <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700">Sign In</button>
                </div>
            </form>
            <p class="mt-4 text-center text-sm text-gray-600">
                belum ada akun? <a href="#" class="text-indigo-600 hover:text-indigo-500">daftar disini!!!</a>
            </p>
        </div>
    </div>
    <!--end modal login-->

    <!---pop up-->
    <div id="popup-overlay" class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-60 flex justify-center items-center z-50">
        <div class="bg-[#363434] p-8 rounded-lg max-w-4xl w-full h-[650px] relative flex flex-col">
            <i id="close-popup" class='bx bx-x absolute top-4 right-4 cursor-pointer text-white bg-red-500 rounded-full p-2 w-10 h-10 flex items-center justify-center'></i>
            <div class="grid grid-cols-2 grid-rows-2 gap-4 h-full">
                <div class="flex justify-center items-center p-2">
                    <img src="../asset/foto/logo_onema-removebg(1).png" alt="" class="w-64 h-64 object-cover">
                </div>
                <div class="flex flex-col justify-between p-4">
                    <div class="flex flex-col space-y-4">
                        <div class="flex space-x-4 mt-56">
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
                <div class="flex flex-col justify-between p-4 -mt-20">
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
        <div class="h-full px-3 py-4 overflow-y-auto bg-[#363434]" style="border-radius: 0 1rem 1rem 0; overflow:hidden;">
            <ul class="space-y-2 font-medium">
                <!-- Label User dengan Background Color -->
                <li>
                    <span class="block px-2 py-1 text-sm font-semibold text-gray dark:text-gray-400 bg-gray-700 rounded">Profile</span>
                </li>
                <!-- Opsi untuk User -->
                <li>
                    <a href="#" id="akun-link" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                            <path d="M17 5.923A1 1 0 0 0 16 5h-3V4a4 4 0 1 0-8 0v1H2a1 1 0 0 0-1 .923L.086 17.846A2 2 0 0 0 2.08 20h13.84a2 2 0 0 0 1.994-2.153L17 5.923ZM7 9a1 1 0 0 1-2 0V7h2v2Zm0-5a2 2 0 1 1 4 0v1H7V4Zm6 5a1 1 0 1 1-2 0V7h2v2Z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Akun</span>
                    </a>

                </li>
                <li>
                    <a href="#" id="settings-link" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                            <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                            <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                        </svg>
                        <span class="ms-3">Settings</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                            <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                            <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                        </svg>
                        <span class="ms-3">Watchlist</span>
                    </a>
                </li>
                <!-- Label Admin dengan Background Color -->
                <li>
                    <span class="block px-2 py-1 text-sm font-semibold text-gray-300 dark:text-gray-400 bg-gray-700 rounded">Tambah</span>
                </li>
                <!-- Opsi untuk Admin -->
                <li>
                    <a href="#" id="tambah-link" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path d="M12 5v14m7-7H5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span class="ms-3">Tambah</span>
                        <span class="inline-flex items-center justify-center px-2 ml-3 text-sm font-medium text-gray-800 bg-gray-200 rounded-full dark:bg-gray-700 dark:text-gray-300">opsional</span>
                    </a>
                </li>
                <li>
                    <a href="#" id="info-link" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0C5.383 0 0 5.383 0 12s5.383 12 12 12 12-5.383 12-12S18.617 0 12 0zm0 22C6.486 22 2 17.514 2 12S6.486 2 12 2s10 4.486 10 10-4.486 10-10 10z" />
                            <path d="M11 10h2v7h-2zm0-4h2v2h-2z" />
                        </svg>
                        <span class="ms-3">Info</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                            <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                            <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                        </svg>
                        <span class="ms-3">Lainnya</span>
                    </a>
                </li>
            </ul>
            <div id="dropdown-cta" class="p-4 mt-6 rounded-lg bg-blue-50 dark:bg-blue-900" role="alert">
                <div class="flex items-center mb-3">
                    <span class="bg-orange-100 text-orange-800 text-sm font-semibold me-2 px-2.5 py-0.5 rounded dark:bg-orange-200 dark:text-orange-900">Info Penting</span>
                    <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-blue-50 inline-flex justify-center items-center w-6 h-6 text-blue-900 rounded-lg focus:ring-2 focus:ring-blue-400 p-1 hover:bg-blue-200 dark:bg-blue-900 dark:text-blue-400 dark:hover:bg-blue-800" data-dismiss-target="#dropdown-cta" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
                <p class="mb-3 text-sm text-blue-800 dark:text-blue-400">
                    Preview the new Flowbite dashboard navigation! You can turn the new navigation off for a limited time in your profile.
                </p>
                <a class="text-sm text-blue-800 underline font-medium hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" href="#">Turn new navigation off</a>
            </div>
        </div>
    </aside>
    <!--end side bar -->

    <!--home-->
    <div id="main-content">
        <!-- Slider Section -->
        <div class="flex flex-col lg:flex-row my-8 px-4">
            <!-- Slider Section -->
            <div class="flex flex-col lg:flex-row my-8 px-4 lg:px-32">
                <!-- Slider -->
                <div class="relative w-full lg:w-3/4 lg:mr-16 h-[500px]">
                    <div class="slider h-full">
                        <div class="slides h-full flex">
                            @foreach ($slider as $item)
                            <div class="slide relative h-full flex-shrink-0 w-full">

                                <a href="{{ route('home.detail', $item->id) }}">
                                    <img src="{{ asset('upload/' . $item->poster) }}" alt="Background Poster" class="w-full h-full object-cover rounded-lg shadow-lg mask-gradient" />
                                </a>

                                <div class="absolute bottom-10 left-0 w-full flex items-center px-8">

                                    <div class="poster-container h-[200px] w-[140px] flex-shrink-0 mr-6 relative">
                                        <a href="{{ route('home.detail', $item->id) }}">
                                            <img src="{{ asset('upload/' . $item->poster) }}" alt="Poster" class="w-full h-full object-cover rounded-lg shadow-lg" />
                                        </a>
                                        <div class="absolute -top-1 -left-1">
                                            <div class="relative">
                                                <i class='bx bxs-bookmark text-gray-500 text-4xl'></i>
                                                <i class='bx bx-plus absolute top-1 text-white text-2xl' style="left: 5px;"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-content flex items-center mt-8">

                                        <button class="play-button bg-red-600 text-white rounded-full w-14 h-14 flex items-center justify-center mr-4">
                                            <i class='bx bx-play text-2xl'></i>
                                        </button>

                                        <div class="info-content flex flex-col">
                                            <h2 class="text-4xl font-extrabold text-slate-800 mb-2 text-shadow-md">{{ $item->title }}</h2>
                                            <p class="text-base text-black mb-4 text-shadow-md">{{ Str::limit($item->deskripsi, 30, '...') }}</p>
                                            <div class="video-duration text-slate-600 font-bold" id="duration-{{ $loop->index }}"></div>
                                            <div class="video-controls hidden">
                                                <div class="video-controls-icon">
                                                    <i class='bx bx-dots-horizontal-rounded text-white text-2xl'></i>
                                                </div>
                                                <div class="current-time text-black font-bold" id="current-time-{{ $loop->index }}"></div>
                                            </div>
                                            <div class="current-time text-black font-bold" id="current-time-{{ $loop->index }}"></div>
                                        </div>
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
                <div class="w-full lg:w-1/3 lg:mt-0 flex flex-col ml-4 lg:ml-8">
                    <h1 class="text-black text-xl font-bold px-4 py-2 rounded-r-lg">
                        <span class="border-l-4 border-black pl-2">Recommended Movies</span>
                    </h1>
                    <section class="flex flex-col space-y-4 mt-4">
                        @foreach ($recommendations as $recommendation)
                        <div class="flex bg-black bg-opacity-75 rounded-md overflow-hidden h-28 w-full max-w-xs shadow-custom">
                            <!-- Video Thumbnail -->
                            <div class="flex-shrink-0 w-1/4 relative">
                                <a href="{{ route('home.detail', $recommendation->id) }}">
                                    <video width="100%" height="100%" poster="{{ asset('upload/' . $recommendation->poster) }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                                        <source src="{{ asset('upload/' . $recommendation->vidio) }}" type="video/mp4">
                                    </video>
                                </a>
                                <div class="absolute top-0 left-0 m-2">
                                    <i class='bx bxs-bookmark-star text-white text-xl'></i>
                                </div>
                                <a href="{{ route('home.detail', $recommendation->id) }}" class="absolute bottom-0 left-0 m-2 play-button">
                                    <div class="play-icon-container play-icon-small">
                                        <i class="fas fa-play text-white"></i>
                                    </div>
                                </a>
                                <div class="video-duration font-bold absolute bottom-0 right-0 m-2"></div>
                            </div>
                            <!-- Title and Description -->
                            <div class="flex-1 p-2 flex flex-col justify-center">
                                <h3 class="text-sm font-semibold text-white truncate">{{ $recommendation->title }}</h3>
                                <p class="text-xs text-white mt-1">{{ Str::limit($recommendation->deskripsi, 50) }}</p>
                            </div>
                        </div>
                        @endforeach
                    </section>
                </div>
            </div>
        </div>

        <!-- Top Onema This Week Section -->
        <div class="px-32 my-8"> <!-- Menambahkan padding horizontal untuk memindahkan konten ke kanan -->
            <h1 class="text-black text-xl font-bold px-0 py-2 mb-6 inline-block rounded-r-lg ml-6">
                <span class="border-l-4 border-black pl-2">Top Onema</span>
            </h1>
            <section>
                <ul class="mt-8 grid grid-flow-row-dense gap-4 sm:grid-cols-3 lg:grid-cols-6">
                    @foreach ($topOnema as $trailers)
                    <li class="p-2 rounded-x overflow-hidden relative text-white"
                        data-title="{{ $trailers->title }}"
                        data-poster="{{ asset('upload/' . $trailers->poster) }}">
                        <!-- Konten trailer lainnya -->
                        <div class="video-container rounded-t-2xl overflow-hidden" id="video-container-{{ $loop->index }}">
                            <a href="{{ route('home.detail', $trailers->id) }}">
                                <video width="100%" height="250" poster="{{ asset('upload/' . $trailers->poster) }}" class="video h-[250px] w-full object-cover transition duration-500 group-hover:scale-105 sm:h-[290px]" id="video-gladiator-{{ $loop->index }}">
                                    <source id="video-source-{{ $loop->index }}" src="{{ asset('upload/' . $trailers->vidio) }}" type="video/mp4">
                                </video>
                            </a>
                            <div class="absolute top-0 left-0 ">
                                <i class='bx bxs-bookmark-star text-white text-2xl'></i>
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
                        <div class="bg-black bg-opacity-75 p-2 rounded-b-2xl">
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
                                @if($trailers->count())
                                @foreach($trailers as $trailer)
                                <i class='bx bx-bookmark ml-10 cursor-pointer text-xl' id="bookmark-{{ $loop->index }}" data-trailer-id="{{ $trailer->id }}"></i>
                                @endforeach
                                @else
                                <p>No trailers available</p>
                                @endif
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

            if (menuLink) {
                menuLink.addEventListener('click', function(event) {
                    event.preventDefault();
                    popupOverlay.classList.add('active');
                });
            }

            if (closePopupButton) {
                closePopupButton.addEventListener('click', function() {
                    popupOverlay.classList.add('closing');
                    setTimeout(function() {
                        popupOverlay.classList.remove('active', 'closing');
                    }, 300);
                });
            }

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
                        recommendationsSection.innerHTML = ''; // Kosongkan konten sebelumnya

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
                                <div class="video-duration font-bold absolute bottom-0 right-0 m-2"></div>
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



            //warna menit
            document.querySelectorAll('.video-thumbnail').forEach(function(thumbnail) {
                const img = thumbnail.querySelector('img');
                const durationText = thumbnail.querySelector('.video-duration');

                if (img) {
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');

                    img.onload = function() {
                        canvas.width = img.width;
                        canvas.height = img.height;
                        ctx.drawImage(img, 0, 0, img.width, img.height);

                        const imageData = ctx.getImageData(0, 0, img.width, img.height);
                        let r = 0,
                            g = 0,
                            b = 0;
                        let count = 0;

                        for (let i = 0; i < imageData.data.length; i += 4) {
                            r += imageData.data[i];
                            g += imageData.data[i + 1];
                            b += imageData.data[i + 2];
                            count++;
                        }

                        // Rata-rata warna
                        r = Math.floor(r / count);
                        g = Math.floor(g / count);
                        b = Math.floor(b / count);

                        // Deteksi apakah warna dominan lebih mendekati putih atau hitam
                        const brightness = (r * 299 + g * 587 + b * 114) / 1000;

                        if (brightness > 150) {
                            // Jika poster terang, buat teks menit menjadi hitam
                            durationText.style.color = "black";
                        } else if (brightness < 50) {
                            // Jika poster sangat gelap, buat teks menit menjadi putih
                            durationText.style.color = "white";
                        } else {
                            // Jika poster berwarna lain, tetap buat teks menjadi putih
                            durationText.style.color = "white";
                        }
                    };
                }
            });

            //slider
            const slides = document.querySelector('.slides');
            const slideCount = document.querySelectorAll('.slide').length;
            let currentIndex = 0;
            let autoSlideInterval;
            let manualSlideTimeout;

            function updateSlidePosition() {
                slides.style.transform = `translateX(-${currentIndex * 100}%)`;
            }

            function startAutoSlide() {
                autoSlideInterval = setInterval(() => {
                    document.getElementById('nextSlide').click();
                }, 8000);
            }

            function resetAutoSlide() {
                clearInterval(autoSlideInterval); // Hentikan sementara penggeseran otomatis
                clearTimeout(manualSlideTimeout); // Hentikan timeout yang sebelumnya ada

                // Tunggu 18 detik sebelum memulai kembali penggeseran otomatis
                manualSlideTimeout = setTimeout(() => {
                    startAutoSlide();
                }, 18000);
            }

            // Kontrol slide manual
            document.getElementById('nextSlide').addEventListener('click', () => {
                if (currentIndex < slideCount - 1) {
                    currentIndex++;
                } else {
                    currentIndex = 0;
                }
                updateSlidePosition();
                resetAutoSlide(5000); // Atur ulang penggeseran otomatis setelah slide manual
            });

            document.getElementById('prevSlide').addEventListener('click', () => {
                if (currentIndex > 0) {
                    currentIndex--;
                } else {
                    currentIndex = slideCount - 1;
                }
                updateSlidePosition();
                resetAutoSlide(18000); // Atur ulang penggeseran otomatis setelah slide manual
            });

            // Memulai penggeseran otomatis saat halaman dimuat
            startAutoSlide();




            // Bookmark 
            document.querySelectorAll('.bx-bookmark').forEach((bookmarkButton, index) => {
                bookmarkButton.addEventListener('click', function() {
                    const trailerId = bookmarkButton.dataset.trailerId; // ID trailer yang akan ditambahkan ke watchlist

                    axios.post(`/watchlist/toggle/${trailerId}`)
                        .then(response => {
                            if (response.data.status === 'added') {
                                bookmarkButton.classList.add('bxs-bookmark');
                                bookmarkButton.classList.remove('bx-bookmark');
                            } else {
                                bookmarkButton.classList.add('bx-bookmark');
                                bookmarkButton.classList.remove('bxs-bookmark');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });


            // search
            const searchInput = document.getElementById('search-input');
            const suggestions = document.getElementById('suggestions');
            const searchHistoryContainer = document.getElementById('search-history');

            // Array untuk menyimpan riwayat pencarian
            let searchHistory = [];

            // Event listener untuk input pencarian
            searchInput.addEventListener('input', function() {
                const searchQuery = this.value.toLowerCase();

                // Hapus riwayat pencarian saat pengguna mengetik
                if (searchQuery) {
                    searchHistoryContainer.classList.add('hidden');
                }

                // Tampilkan saran berdasarkan input
                updateSuggestions(searchQuery);
            });

            // Event listener untuk menangani pencarian saat menekan Enter
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const query = this.value;

                    // Simpan pencarian ke dalam riwayat dan tampilkan riwayat
                    if (query && !searchHistory.includes(query)) {
                        searchHistory.push(query);
                        updateSearchHistory();
                    }

                    performSearch(query);
                }
            });



            // Fungsi untuk memperbarui saran pencarian dengan poster kecil
            function updateSuggestions(query) {
                suggestions.innerHTML = '';

                if (query) {
                    suggestions.classList.remove('hidden');

                    const trailers = document.querySelectorAll('li[data-title]');
                    trailers.forEach(function(trailer) {
                        const title = trailer.getAttribute('data-title').toLowerCase();
                        const posterUrl = trailer.getAttribute('data-poster'); // Mengambil URL poster dari data-poster

                        if (title.includes(query)) {
                            const suggestionItem = document.createElement('a');
                            suggestionItem.href = '#';
                            suggestionItem.className = 'suggestion-item hover:bg-gray-100';

                            // Tambahkan gambar poster kecil
                            const posterImg = document.createElement('img');
                            posterImg.src = posterUrl;
                            posterImg.alt = 'Poster';
                            suggestionItem.appendChild(posterImg);

                            // Tambahkan teks judul
                            const titleText = document.createElement('span');
                            titleText.textContent = trailer.getAttribute('data-title');
                            suggestionItem.appendChild(titleText);

                            // Event klik untuk memilih saran
                            suggestionItem.addEventListener('click', function(e) {
                                e.preventDefault();
                                searchInput.value = trailer.getAttribute('data-title');
                                performSearch(searchInput.value);
                                suggestions.classList.add('hidden');
                            });

                            suggestions.appendChild(suggestionItem);
                        }
                    });

                    if (suggestions.innerHTML === '') {
                        suggestions.classList.add('hidden');
                    }
                } else {
                    suggestions.classList.add('hidden');
                }
            }

            // Fungsi untuk melakukan pencarian dan mengatur scroll halaman
            function performSearch(query) {
                // Lakukan pencarian di sini (kode pencarian dapat disesuaikan)

                // Contoh logika pencarian sederhana: filter elemen berdasarkan judul
                const trailers = document.querySelectorAll('li[data-title]');
                trailers.forEach(function(trailer) {
                    const title = trailer.getAttribute('data-title').toLowerCase();
                    if (title.includes(query.toLowerCase())) {
                        trailer.classList.remove('hidden'); // Tampilkan trailer yang sesuai
                    } else {
                        trailer.classList.add('hidden'); // Sembunyikan trailer yang tidak sesuai
                    }
                });

                // Scroll otomatis ke bagian "Top Onema"
                const topOnemaSection = document.querySelector('.px-32'); // Elemen yang mengandung "Top Onema"
                if (topOnemaSection) {
                    topOnemaSection.scrollIntoView({
                        behavior: 'smooth'
                    });
                }

            }

            // Event listener untuk menangani pencarian saat menekan Enter
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const query = this.value;

                    // Simpan pencarian ke dalam riwayat dan tampilkan riwayat
                    if (query && !searchHistory.includes(query)) {
                        searchHistory.push(query);
                        updateSearchHistory();
                    }

                    performSearch(query); // Panggil fungsi performSearch saat Enter ditekan
                }
            });


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
                }, 10); // Delay to ensure transition is applied
            }

            function hideModal() {
                popupFormOverlay.style.transition = 'opacity 0.3s ease-out, transform 0.3s ease-out';
                popupFormOverlay.style.opacity = '0';
                popupFormOverlay.style.transform = 'scale(0.95)';

                setTimeout(() => {
                    popupFormOverlay.style.display = 'none';
                }, 300); // Match this duration with your transition duration
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

            // Menampilkan kontrol video saat tombol play ditekan
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

            // Memperlihatkan menu kontrol saat ikon titik tiga ditekan
            document.querySelectorAll('.video-controls-icon').forEach(icon => {
                icon.addEventListener('click', function() {
                    const videoControls = this.closest('.video-controls');
                    videoControls.classList.toggle('show');
                });
            });

            // Video Duration
            const videoElements = document.querySelectorAll('video');
            const durationElements = document.querySelectorAll('.video-duration');

            videoElements.forEach((video, index) => {
                const durationElement = durationElements[index];

                if (video && durationElement) {
                    video.addEventListener('loadedmetadata', function() {
                        const duration = video.duration;
                        const minutes = Math.floor(duration / 60);
                        const seconds = Math.floor(duration % 60);
                        const formattedDuration = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
                        durationElement.textContent = formattedDuration;
                    });
                }
            });

            // Kontrol kecepatan
            document.querySelectorAll('.speed-control').forEach(select => {
                select.addEventListener('change', function() {
                    const video = this.closest('.video-controls').previousElementSibling.querySelector('video');
                    video.playbackRate = parseFloat(this.value);
                });
            });

            // Kontrol kualitas
            document.querySelectorAll('.quality-control').forEach(select => {
                select.addEventListener('change', function() {
                    const quality = this.value;
                    const videoContainer = this.closest('.video-controls').previousElementSibling;
                    const video = videoContainer.querySelector('video');
                    const videoSrc = video.querySelector('source').src;

                    // Simpan logika penggantian kualitas video di sini
                    alert(`Kualitas video diubah ke ${quality}p (ini hanya demo, fungsionalitas pengubahan kualitas belum diimplementasikan).`);
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
            // Dapatkan elemen sidebar, konten utama, dan ikon pengaturan
            const settingsIcon = document.getElementById('settings-icon');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');

            // Variabel untuk menyimpan posisi scroll
            let scrollPosition = 0;

            // Fungsi untuk menampilkan/menyembunyikan sidebar
            function toggleSidebar() {
                if (sidebar.classList.contains('visible')) {
                    // Simpan posisi scroll saat sidebar ditutup
                    scrollPosition = window.scrollY;
                    sidebar.classList.remove('visible');
                    mainContent.classList.remove('shifted');
                    localStorage.setItem('sidebarVisible', 'false');

                    // Tunggu sedikit sebelum mengembalikan scroll
                    setTimeout(() => {
                        window.scrollTo(0, scrollPosition);
                    }, 0); // Penundaan kecil
                } else {
                    // Simpan posisi scroll saat sidebar dibuka
                    scrollPosition = window.scrollY;
                    sidebar.classList.add('visible');
                    mainContent.classList.add('shifted');
                    localStorage.setItem('sidebarVisible', 'true');

                    // Tunggu sedikit sebelum memulihkan posisi scroll
                    setTimeout(() => {
                        window.scrollTo(0, scrollPosition);
                    }, 0); // Penundaan kecil
                }
            }

            // Tambahkan event listener untuk mengubah status sidebar ketika ikon pengaturan diklik
            settingsIcon.addEventListener('click', toggleSidebar);

            // Cek status awal sidebar dari localStorage saat halaman dimuat
            const isSidebarVisible = localStorage.getItem('sidebarVisible') === 'true';
            if (isSidebarVisible) {
                sidebar.classList.add('visible');
                mainContent.classList.add('shifted');
            } else {
                sidebar.classList.remove('visible');
            }

            // Panggil fungsi penyesuaian grid video setelah halaman selesai dimuat
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
                    infoModal.classList.add('fade-in'); // Tambahkan animasi fade-in
                });

                closeInfoModal.addEventListener('click', function() {
                    infoModal.classList.add('fade-out'); // Tambahkan animasi fade-out
                    setTimeout(function() {
                        infoModal.classList.add('hidden');
                        infoModal.classList.remove('fade-in', 'fade-out');
                    }, 300); // Waktu animasi fade-out
                });

                window.addEventListener('click', function(event) {
                    if (event.target === infoModal) {
                        infoModal.classList.add('fade-out'); // Tambahkan animasi fade-out
                        setTimeout(function() {
                            infoModal.classList.add('hidden');
                            infoModal.classList.remove('fade-in', 'fade-out');
                        }, 300); // Waktu animasi fade-out
                    }
                });
            }

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
            const closeButton = document.querySelector('[data-dismiss-target="#dropdown-cta"]');
            const alertBox = document.getElementById('dropdown-cta');

            if (closeButton && alertBox) {
                closeButton.addEventListener('click', function() {
                    alertBox.remove();
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
                // Implementasi untuk mengganti bahasa sesuai pilihan
                if (language === 'english') {
                    // Ganti teks ke bahasa Inggris
                } else {
                    // Ganti teks ke bahasa Indonesia
                }
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