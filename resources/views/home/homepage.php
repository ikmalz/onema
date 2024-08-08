<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>movie review</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
        }

        .dropdown-menu.show {
            display: block;
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
            display: none;
        }

        #loginModal {
            display: none;
        }

        .sidebar-hidden {
            transform: translateX(-100%);
        }

        .sidebar-visible {
            transform: translateX(0);
        }

        #cta-button-sidebar {
            transition: transform 0.3s ease;
        }

        .show {
            display: block;
        }

        .rotate-180 {
            transform: rotate(180deg);
        }

        .hidden {
            display: none;
        }

        /* Tambahkan CSS ini untuk memastikan popup akun berada di atas */
        #akun-popup {
            z-index: 50;
            /* Pastikan nilai ini lebih tinggi dari elemen lain */
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


    </style>
</head>

<body class="font-poppins">
    <!--header-->
    <header class="bg-[#E52B09]">
        <div class="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-12">
                    <a class="block text-teal-600" href="#">
                        <span class="sr-only">Home</span>
                        <img src="../asset/foto/logoonema.png" alt="Logo" class="w-20 h-20">
                    </a>
                </div>

                <div class="hidden md:flex items-center flex-grow ml-8">
                    <div class="relative flex items-center max-w-full w-full">
                        <button id="dropdownButton" class="relative bg-gray-300 px-4 text-sm font-medium text-gray-700 rounded-l-md flex items-center h-full py-2" style="padding-top: 9px; padding-bottom:9px;">
                            All
                            <i id="dropdownArrow" class='bx bx-chevron-down h-4 w-4 ml-2 transition-transform duration-300'></i>
                        </button>

                        <div id="dropdownMenu" class="dropdown-menu rounded-md shadow-lg hidden absolute mt-2 bg-white">
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100"><i class='bx bx-search-alt-2'></i> All</a>
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100"><i class='bx bxs-detail'></i> Titles</a>
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100"><i class='bx bx-tv'></i> TV Episodes</a>
                        </div>

                        <div class="relative flex-1 flex items-center">
                            <input type="text" class="pl-10 pr-12 py-2 text-sm border rounded-r-md h-full w-full" placeholder="Search..." />
                            <i class='bx bx-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 font-2xl'></i>
                        </div>

                        <div class="flex items-center ml-4">
                            <a id="menu-link" href="#" class="flex items-center">
                                <i class='bx bx-menu text-black font-bold' style="font-size: 30px;"></i>
                                <span class="text-white font-semibold text-sm ml-2">Menu</span>
                            </a>
                            <div class="h-6 border-l border-gray-400 mx-2"></div>
                            <a href="link-ke-watchlist" class="flex items-center">
                                <i class='bx bxs-bookmark-star text-white font-bold' style="font-size: 24px;"></i>
                                <span class="text-white font-semibold text-sm ml-2">Watchlist</span>
                            </a>
                        </div>

                        <div class="flex items-center ml-4">
                            <button class="bg-red-700 text-white py-2 px-4 border-2 border-transparent rounded shadow hover:bg-red-800">
                                Sign In
                            </button>
                        </div>

                        <div class="flex items-center ml-4">
                            <a id="settings-icon" href="#" class="flex items-center">
                            <i class='bx bxs-category text-white'style="font-size: 24px;"></i>
                            </a>

                        </div>

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

    <!-- side bar -->
    <aside id="cta-button-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen sidebar-hidden" aria-label="Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto bg-[#363434] rounded-r-lg" style="list-style-type: none;">
            <ul class=" space-y-2 font-medium">
                <li>
                    <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                            <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                            <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                        </svg>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#" id="tambah-link" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path d="M12 5v14m7-7H5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span class="ms-3">Tambah</span>
                        <span class="inline-flex items-center justify-center px-2 ml-3 text-sm font-medium text-gray-800 bg-gray-200 rounded-full dark:bg-gray-700 dark:text-gray-300">Pro</span>
                    </a>

                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0C5.383 0 0 5.383 0 12s5.383 12 12 12 12-5.383 12-12S18.617 0 12 0zm0 22C6.486 22 2 17.514 2 12S6.486 2 12 2s10 4.486 10 10-4.486 10-10 10z" />
                            <path d="M11 10h2v7h-2zm0-4h2v2h-2z" />
                        </svg>
                        <span class="ms-3">Pemberitahuan</span>
                        <span class="inline-flex items-center justify-center px-2 ml-3 text-sm font-medium text-gray-800 bg-gray-200 rounded-full dark:bg-gray-700 dark:text-gray-300">3</span>
                    </a>

                </li>
            </ul>
            <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                    <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z" />
                </svg>
                <span class="flex-1 ms-3 whitespace-nowrap">Users</span>
            </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                        <path d="M17 5.923A1 1 0 0 0 16 5h-3V4a4 4 0 1 0-8 0v1H2a1 1 0 0 0-1 .923L.086 17.846A2 2 0 0 0 2.08 20h13.84a2 2 0 0 0 1.994-2.153L17 5.923ZM7 9a1 1 0 0 1-2 0V7h2v2Zm0-5a2 2 0 1 1 4 0v1H7V4Zm6 5a1 1 0 1 1-2 0V7h2v2Z" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Products</span>
                </a>
            </li>
            <li>
                <a href="#" id="account-link" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                        <path d="M17 5.923A1 1 0 0 0 16 5h-3V4a4 4 0 1 0-8 0v1H2a1 1 0 0 0-1 .923L.086 17.846A2 2 0 0 0 2.08 20h13.84a2 2 0 0 0 1.994-2.153L17 5.923ZM7 9a1 1 0 0 1-2 0V7h2v2Zm0-5a2 2 0 1 1 4 0v1H7V4Zm6 5a1 1 0 1 1-2 0V7h2v2Z" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap" id="akun-link">Akun</span>
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

    <!-- Modal Tambah form -->
    <div id="popup-form-overlay" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md mx-auto">
            <button id="close-popup-form" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <p class="text-gray-800 text-lg font-bold mb-4">Masukkan video</p>
            <form class="w-full max-w-lg">
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-title">
                            Judul Film
                        </label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-title" type="text" placeholder="Contoh Film">
                        <p class="text-gray-600 text-xs italic">Masukkan judul film</p>
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-description">
                            Deskripsi Video
                        </label>
                        <textarea class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-description" placeholder="Masukkan deskripsi video"></textarea>
                        <p class="text-gray-600 text-xs italic">Masukkan deskripsi singkat tentang video</p>
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="video-upload">
                            Unggah Video
                        </label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="video-upload" type="file" accept="video/*">
                        <p class="text-gray-600 text-xs italic">Pilih file video untuk diunggah</p>
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-release-year">
                            Tahun Rilis
                        </label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-release-year" type="text" placeholder="2024">
                    </div>
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-popularity">
                            Populer
                        </label>
                        <div class="relative">
                            <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-popularity">
                                <option>Populer</option>
                                <option>Sedang Populer</option>
                                <option>Tidak Populer</option>
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
    <div id="akun-popup" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white max-w-md rounded-lg overflow-hidden shadow-lg relative">
            <button id="close-akun-popup" class="absolute top-2 right-2 p-2 text-gray-500 hover:text-gray-900">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close</span>
            </button>
            <div class="text-center p-6 border-b">
                <img class="h-24 w-24 rounded-full mx-auto" src="https://randomuser.me/api/portraits/men/24.jpg" alt="Randy Robertson" />
                <p class="pt-2 text-lg font-semibold">Randy Robertson</p>
                <p class="text-sm text-gray-600">randy.robertson@example.com</p>
                <div class="mt-5">
                    <a href="#" class="border rounded-full py-2 px-4 text-xs font-semibold text-gray-700">Manage your Google Account</a>
                </div>
            </div>
            <div class="border-b">
                <a href="#" class="px-6 py-3 hover:bg-gray-200 flex items-center">
                    <div class="w-8 h-8 bg-blue-700 rounded-full text-center text-white text-lg flex items-center justify-center">D</div>
                    <div class="pl-3">
                        <p class="text-sm font-semibold">Johnny Depp</p>
                        <p class="text-xs text-gray-600">johnny.depp@example.org</p>
                    </div>
                </a>
                <a href="#" class="px-6 py-3 hover:bg-gray-200 flex items-center">
                    <div class="w-8 h-8 rounded-full text-center">
                        <img class="w-6 h-6 rounded-full mx-auto" src="https://img.icons8.com/windows/50/000000/add-user-male.png" alt="Add User">
                    </div>
                    <div class="pl-3">
                        <p class="text-sm font-semibold text-gray-700">Add another account</p>
                    </div>
                </a>
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

    <!--modal login-->
    <div id="loginModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-gray-900 mx-auto pb-10">Sign in to your account</h2>
                <button id="closeModal" class="text-gray-600 hover:text-gray-900">&times;</button>
            </div>
            <form class="space-y-6" action="#" method="POST">
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

    <!--home-->
    <section>
        <ul class="mt-8 grid gap-4 sm:grid-cols-3 lg:grid-cols-6 px-4">
            <li class="p-2 rounded-2xl overflow-hidden relative">
                <a href="detail">
                    <div class="video-container rounded-t-2xl overflow-hidden" id="video-container">
                        <video width="100%" height="250" poster="https://deadline.com/wp-content/uploads/2024/07/G2_DOM_Online_Teaser_1-Sheet_07_FIN4.jpg?w=800" class="h-[250px] w-full object-cover transition duration-500 group-hover:scale-105 sm:h-[290px]" id="video-gladiator">
                            <source src="{{ asset('asset/vidio/GLADIATOR_Official_Trailer_Paramount_Movies.mp4') }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <div class="absolute top-0 left-0 m-2">
                            <i class='bx bxs-bookmark-star text-white text-2xl'></i>
                        </div>
                        <div class="absolute bottom-0 left-0 m-2 play-button">
                            <div class="play-icon-container">
                                <i class='bx bx-play text-white'></i>
                            </div>
                            <div class="video-duration text-white font-bold">1:34</div>
                        </div>
                    </div>
                </a>

                <div class="bg-black bg-opacity-75 p-2 rounded-b-2xl">
                    <h3 class="text-sm text-white">Official trailer</h3>
                    <h3 class="text-xl text-white mt-1 font-semibold mt-3 mb-10">gladiator II</h3>
                    <i class='bx bx-like mr-10'></i>
                    <i class='bx bxs-bookmark-star'></i>
                </div>
            </li>


            <li class="p-2 rounded-2xl overflow-hidden relative">
                <a href="#" class="group block overflow-hidden relative">
                    <div class="video-container rounded-t-2xl overflow-hidden">
                        <video width="100%" height="250" poster="https://image.tmdb.org/t/p/original/rzEmN6l7yWDH9KttH4yXrDftL53.jpg" class="h-[250px] w-full object-cover transition duration-500 group-hover:scale-105 sm:h-[290px]" id="video-bighero">
                            <source src="../asset/video/BIG HERO 6 _ UK Teaser Trailer _ Official Disney UK.mp4" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <div class="absolute top-0 left-0 m-2">
                            <i class='bx bxs-bookmark-star text-white text-2xl'></i>
                        </div>
                        <div class="absolute bottom-0 left-0 m-2 play-button">
                            <div class="play-icon-container">
                                <i class='bx bx-play text-white'></i>
                            </div>
                            <div class="video-duration text-white font-bold">1:36</div>
                        </div>
                    </div>
                </a>
                <div class="bg-black bg-opacity-75 p-2 rounded-b-2xl">
                    <h3 class="text-sm text-white">Official trailer</h3>
                    <h3 class="text-xl text-white mt-1 font-semibold mt-3 mb-10">Big hero 6</h3>
                    <i class='bx bx-like mr-10'></i>
                    <i class='bx bxs-bookmark-star'></i>
                </div>
            </li>

            <li class="p-2 rounded-2xl overflow-hidden relative">
                <a href="#" class="group block overflow-hidden relative">
                    <div class="video-container rounded-t-2xl overflow-hidden">
                        <video width="100%" height="250" poster="https://lumiere-a.akamaihd.net/v1/images/mufasa_teaser_poster_united_kingdom_6bea24de.jpeg?region=0,0,770,1100" class="h-[250px] w-full object-cover transition duration-500 group-hover:scale-105 sm:h-[290px]" id="video-bighero">
                            <source src="../asset/video/MUFASA_ The Lion King - TEASER TRAILER (2024) Live-Action Movie, Disney+.mp4" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <div class="absolute top-0 left-0 m-2">
                            <i class='bx bxs-bookmark-star text-white text-2xl'></i>
                        </div>
                        <div class="absolute bottom-0 left-0 m-2 play-button">
                            <div class="play-icon-container">
                                <i class='bx bx-play text-white'></i>
                            </div>
                            <div class="video-duration text-white font-bold">1:01</div>
                        </div>
                    </div>
                </a>
                <div class="bg-black bg-opacity-75 p-2 rounded-b-2xl">
                    <h3 class="text-sm text-white">Official trailer</h3>
                    <h3 class="text-xl text-white mt-1 font-semibold mt-3 mb-10">Mufasa</h3>
                    <i class='bx bx-like mr-10'></i>
                    <i class='bx bxs-bookmark-star'></i>
                </div>
            </li>

            <li class="p-2 rounded-2xl overflow-hidden relative">
                <a href="#" class="group block overflow-hidden relative">
                    <div class="video-container rounded-t-2xl overflow-hidden">
                        <video width="100%" height="250" poster="https://lumiere-a.akamaihd.net/v1/images/p_moana2_3113-v3_075bd347.jpeg" class="h-[250px] w-full object-cover transition duration-500 group-hover:scale-105 sm:h-[290px]" id="video-bighero">
                            <source src="../asset/video/Y2meta.app-Moana 2 _ Teaser Trailer-(720p).mp4" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <div class="absolute top-0 left-0 m-2">
                            <i class='bx bxs-bookmark-star text-white text-2xl'></i>
                        </div>
                        <div class="absolute bottom-0 left-0 m-2 play-button">
                            <div class="play-icon-container">
                                <i class='bx bx-play text-white'></i>
                            </div>
                            <div class="video-duration text-white font-bold">2:30</div>
                        </div>
                    </div>
                </a>
                <div class="bg-black bg-opacity-75 p-2 rounded-b-2xl">
                    <h3 class="text-sm text-white">Official trailer</h3>
                    <h3 class="text-xl text-white mt-1 font-semibold mt-3 mb-10">Moana 2</h3>
                    <i class='bx bx-like mr-10'></i>
                    <i class='bx bxs-bookmark-star'></i>
                </div>
            </li>
        </ul>
    </section>
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
                    popupOverlay.style.display = 'flex';
                });
            }

            if (closePopupButton) {
                closePopupButton.addEventListener('click', function() {
                    popupOverlay.style.display = 'none';
                });
            }

            // Popup form
            const addButton = document.querySelector('#tambah-link'); 
            const popupFormOverlay = document.getElementById('popup-form-overlay');
            const closePopupFormButton = document.getElementById('close-popup-form');

            if (addButton) {
                addButton.addEventListener('click', function(event) {
                    event.preventDefault();
                    popupFormOverlay.style.display = 'flex';
                });
            }

            if (closePopupFormButton) {
                closePopupFormButton.addEventListener('click', function() {
                    popupFormOverlay.style.display = 'none';
                });
            }

            window.addEventListener('click', function(event) {
                if (event.target === popupFormOverlay) {
                    popupFormOverlay.style.display = 'none';
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

            // Play video
            document.querySelectorAll('.play-button').forEach(button => {
                button.addEventListener('click', function() {
                    const video = this.closest('.video-container').querySelector('video');
                    video.play();
                    video.setAttribute('controls', 'controls');
                    this.style.display = 'none';
                });
            });

            // Dropdown menu
            const dropdownButton = document.getElementById('dropdownButton');
            const dropdownMenu = document.getElementById('dropdownMenu');
            const dropdownArrow = document.getElementById('dropdownArrow');

            if (dropdownButton) {
                dropdownButton.addEventListener('click', function() {
                    dropdownMenu.classList.toggle('show');
                    dropdownArrow.classList.toggle('rotate-180');
                });
            }

            document.addEventListener('click', function(event) {
                if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.classList.remove('show');
                    dropdownArrow.classList.remove('rotate-180');
                }
            });

            // Sidebar
            const settingsIcon = document.getElementById('settings-icon');
            const sidebar = document.getElementById('cta-button-sidebar');

            if (settingsIcon) {
                settingsIcon.addEventListener('click', function(event) {
                    event.preventDefault();
                    sidebar.classList.toggle('sidebar-visible');
                    sidebar.classList.toggle('sidebar-hidden');
                });
            }

            // Popup when clicking "Akun"
            const akunLink = document.getElementById('akun-link');
            const akunPopup = document.getElementById('akun-popup');
            const closeAkunPopup = document.getElementById('close-akun-popup');

            if (akunLink) {
                akunLink.addEventListener('click', function(event) {
                    event.preventDefault();
                    akunPopup.style.display = 'flex';
                });
            }

            if (closeAkunPopup) {
                closeAkunPopup.addEventListener('click', function() {
                    akunPopup.style.display = 'none';
                });
            }

            window.addEventListener('click', (e) => {
                if (e.target === akunPopup) {
                    akunPopup.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>