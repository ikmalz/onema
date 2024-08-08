<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons/css/boxicons.min.css">
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
    }

    #popup-overlay {
        display: none;
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

    #loginModal {
        display: none;
    }
</style>

<body>
    <header class="bg-[#E52B09] shadow-md" style="box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);">
        <div class="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-12">
                    <a class="block text-teal-600" href="#">
                        <span class="sr-only">Home</span>
                        <img src="logo onema.png" alt="" class="w-20 h-20">
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
                    <img src="logo_onema-removebg (1).png" alt="" class="w-64 h-64 object-cover">
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

    <!-- Video -->
    <div class="max-w-screen-xl mx-auto p-5">
        <div class="flex flex-row items-start mb-5">
            <div class="relative w-1/2 mt-10">
                <div id="video-container" class="video-container">
                    <img id="thumbnail" src="https://rukminim2.flixcart.com/image/850/1000/kt0enww0/poster/r/t/n/medium-crowe-gladiator-movie-matte-finish-poster-original-imag6ghspeugdwng.jpeg?q=90&crop=false" alt="Video Thumbnail" class="rounded-l-lg rounded-r-none">
                    <video id="video" class="hidden rounded-l-lg rounded-r-none" controls>
                        <source src="../asset/video/GLADIATOR_Official_Trailer_Paramount_Movies.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <button id="playButton" class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white bg-opacity-80 border-none rounded-full p-4 cursor-pointer z-10">
                        <i class='bx bx-play text-6xl text-black'></i>
                    </button>
                    <span id="durationLabel" class="absolute bottom-4 left-4 bg-black bg-opacity-75 text-white text-sm px-2 py-1 rounded">
                        2:30
                    </span>
                </div>
            </div>
            <div id="background-container" class="w-1/2 bg-[#363434] text-white px-8 py-3 rounded-r-lg rounded-l-none -mt-5 flex flex-col pt-5" style="min-height: 447px;">
                <div class="flex items-start mb-5">
                    <img src="https://rukminim2.flixcart.com/image/850/1000/kyvvtzk0/poster/d/x/8/medium-gladiator-matte-finish-poster-urbanprint6311-original-imagbygdgnhbdj8z.jpeg?q=90&crop=false" alt="Poster Image" class="w-24 h-auto rounded-xl mr-4">
                    <div>
                        <h2 class="text-base font-bold mb-1">Name film</h2>
                        <p class="text-sm mb-1">Genre</p>
                    </div>
                </div>
                <div class="flex flex-col justify-end pt-15">
                    <hr class="border-t-2 border-gray-300 w-full mb-4">
                    <h2 class="text-2xl font-bold mb-2 px-14">Gladiator</h2>
                    <p class="text-xs font-normal text-justify px-24">
                    "Gladiator" (2000) adalah film epik sejarah yang disutradarai oleh Ridley Scott. 
                    Menceritakan kisah Maximus, seorang jenderal Romawi yang dikhianati dan dijadikan 
                    budak setelah keluarganya dibunuh. Sebagai gladiator, Maximus berjuang untuk membalas 
                    dendam dan mengembalikan kehormatannya. Film ini terkenal dengan aksi spektakuler dan 
                    penampilan luar biasa dari Russell Crowe.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Video -->



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Buat pop up
            const menuLink = document.getElementById('menu-link');
            const popupOverlay = document.getElementById('popup-overlay');
            const closePopupButton = document.getElementById('close-popup');

            menuLink.addEventListener('click', function(event) {
                event.preventDefault();
                popupOverlay.style.display = 'flex';
            });

            closePopupButton.addEventListener('click', function() {
                popupOverlay.style.display = 'none';
            });

            // buat modal
            const loginModal = document.getElementById('loginModal');
            const signInButton = document.querySelector('button.bg-red-700');
            const closeModal = document.getElementById('closeModal');

            signInButton.addEventListener('click', () => {
                loginModal.style.display = 'flex';
            });

            closeModal.addEventListener('click', () => {
                loginModal.style.display = 'none';
            });

            window.addEventListener('click', (e) => {
                if (e.target === loginModal) {
                    loginModal.style.display = 'none';
                }
                if (e.target === popupOverlay) {
                    popupOverlay.style.display = 'none';
                }
            });

            // buat play video
            const playButton = document.getElementById('playButton');
            const video = document.getElementById('video');
            const thumbnail = document.getElementById('thumbnail');
            const durationLabel = document.getElementById('durationLabel'); 
            const backgroundContainer = document.getElementById('background-container');

            playButton.addEventListener('click', () => {
                thumbnail.style.display = 'none';
                video.style.display = 'block';
                video.play();
                playButton.style.display = 'none';
                durationLabel.style.display = 'none'; 
                adjustBackgroundHeight();
            });

            video.addEventListener('play', () => {
                playButton.style.display = 'none';
                durationLabel.style.display = 'none'; 
                adjustBackgroundHeight();
            });

            video.addEventListener('pause', () => {
                playButton.style.display = 'block';
            });

            video.addEventListener('ended', () => {
                playButton.style.display = 'block';
            });

            function adjustBackgroundHeight() {
                const videoHeight = video.offsetHeight;
                const minHeight = -60; 

                const newHeight = Math.max(videoHeight - minHeight, 0); 
                backgroundContainer.style.minHeight = newHeight + 'px';
                backgroundContainer.style.height = newHeight + 'px';
            }

            // Fungsi menu dropdown
            const dropdownButton = document.getElementById('dropdownButton');
            const dropdownMenu = document.getElementById('dropdownMenu');
            const dropdownArrow = document.getElementById('dropdownArrow');

            dropdownButton.addEventListener('click', function() {
                dropdownMenu.classList.toggle('show');
                dropdownArrow.classList.toggle('rotate-180');
            });

            document.addEventListener('click', function(event) {
                if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.classList.remove('show');
                    dropdownArrow.classList.remove('rotate-180');
                }
            });
        });
    </script>


</body>

</html>