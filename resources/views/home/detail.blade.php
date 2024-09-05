<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
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

    .video-container {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .options-menu {
        position: absolute;
        top: 100%;
        right: 0;
        background-color: #333;
        color: white;
        border-radius: 0.5rem;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 20;
    }

    .hidden {
        display: none;
    }

    /* Pesan dari Pengguna Lain */
    .message.other-user {
        justify-content: flex-start;
        margin-left: 1rem;
    }

    .message.other-user img {
        order: -1;
    }

    .message.other-user .message-text {
        background-color: #f0f0f0;
        /* abu-abu */
        color: #333;
        border-radius: 0.5rem 1rem 1rem 1rem;
        padding: 0.75rem;
        /* Padding tambahan untuk isi pesan */
        margin-right: 0.5rem;
        /* Margin tambahan untuk jarak dengan gambar */
    }

    /* Pesan Pengguna Sendiri */
    .message.self-user {
        justify-content: flex-end;
        margin-right: 1rem;
    }

    .message.self-user img {
        order: 1;
    }

    .message.self-user .message-text {
        background-color: #007bff;
        color: #fff;
        border-radius: 1rem 0.5rem 1rem 1rem;
        padding: 0.75rem;
        margin-left: 0.5rem;
    }

    .text-container {
        max-height: 7.5em;
        /* 5 baris dengan line-height 1.5em */
        overflow: hidden;
    }

    .text-ellipsis {
        max-height: 7.5em;
        /* 5 lines with line-height 1.5em */
        overflow: hidden;
        position: relative;
        line-height: 1.5em;
    }


    .read-more {
        margin-top: 8px;
        cursor: pointer;
        border: none;
        background: none;
        color: blue;
        text-decoration: underline;
    }

    .message {
        position: relative;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        right: 0;
        top: 100%;
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
        z-index: 10;
    }

    .dropdown-menu.show {
        display: block;
    }

    .dropdown-menu button {
        display: block;
        width: 100%;
        padding: 8px;
        text-align: left;
        border: none;
        background: none;
        cursor: pointer;
        color: #333;
    }

    .dropdown-menu button:hover {
        background-color: #f5f5f5;
    }

    .video-size {
        max-width: 80%;
        max-height: 60vh;
        margin: 0 auto;
    }

    .thumbnail-size {
        max-width: 80%;
        max-height: 60vh;
        margin: 0 auto;
        border: #333 3px solid;

    }

    #durationLabel {
        position: absolute;
        bottom: 2%;
        left: 10%;
        background-color: rgba(0, 0, 0, 0.75);
        color: white;
        font-size: 0.75rem;
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
    }
</style>

<body>
    <header class="bg-[#E52B09] shadow-md" style="box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);">
        <div class="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-12">
                    <a class="block text-teal-600" href="#">
                        <span class="sr-only">Home</span>
                        <img src="../asset/foto/logoonema.png" alt="Logo" class="w-20 h-20 ">
                    </a>
                    <a href="{{ route('home') }}" class="flex items-center text-white hover:text-gray-400">
                        <i class='bx bxs-left-arrow-alt'></i> Kembali
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
                            <div class="h-6 border-l border-gray-400 mx-2"></div>
                            <a href="link-ke-watchlist" class="flex items-center">
                                <i class='bx bxs-bookmark-star text-white font-bold' style="font-size: 24px;"></i>
                                <span class="text-white font-semibold text-sm ml-2">Watchlist</span>
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


    <section class="max-w-screen-lg mx-auto p-3">
        <!-- Video Section -->
        <div id="video-container" class="relative w-full mt-6">
            <video id="video" class="rounded-lg video-size" controls autoplay>
                <source src="{{ asset('upload/' . $detail->vidio) }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    </section>

    </section>


    <!-- Section for Background Content -->
    <section class="max-w-screen-lg mx-auto p-3 mt-8">
        <!-- Background Section -->
        <div id="background-container" class="w-full max-w-3xl mx-auto text-white px-6 py-12 rounded-t-lg bg-gray-800 flex flex-col md:flex-row">

            <!-- Poster Section -->
            <div class="w-full md:w-1/2 mb-4 md:mb-0">
                <img src="{{ asset('upload/' . $detail->poster) }}" alt="Poster Image" class="rounded-lg w-full h-auto object-cover" style="max-height: 500px; object-fit: cover;">
            </div>

            <!-- Content Section -->
            <div class="flex-grow mt-4 md:mt-0 md:ml-6 flex flex-col justify-center">
                <!-- Information Section -->
                <div class="md:mb-4">
                    <h2 class="text-4xl font-bold mb-2">{{$detail->title}}</h2>
                    <p class="text-sm mb-1">Tanggal Publish: {{$detail->tahun}}</p>
                    <p class="text-sm mb-1">Genre: {{$detail->populer}}</p>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-yellow-300 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                            <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                        </svg>
                        <p class="ms-2 text-sm font-bold text-gray-900 dark:text-white">4.95</p>
                        <span class="w-1 h-1 mx-1.5 bg-gray-500 rounded-full dark:bg-gray-400"></span>
                        <a href="#" class="text-sm font-medium text-gray-900 underline hover:no-underline dark:text-white">73 reviews</a>
                    </div>
                </div>
            </div>
        </div>


        <!-- Deskripsi Section -->
        <div class="bg-gray-800 pl-7 pr-8 py-4 w-full max-w-3xl mx-auto ">
            <hr class="border-gray-600 my-4">
            <p class="text-xl text-justify text-white font-bold pb-1">Deskripsi</p>
            <p id="deskripsi-part1" class="text-sm text-justify text-white"></p>
            <p id="deskripsi-part2" class="text-sm text-justify text-white hidden"></p>
            <button id="read-more-deskripsi" class="text-red-700 hover:underline mt-2 hidden">Baca Selengkapnya</button>
            <hr class="border-gray-600 my-4">
        </div>


        <!-- Chat Section -->
        <div id="chat-container" class="w-full max-w-3xl mx-auto bg-gray-800 p-4 rounded-b-lg flex flex-col h-full">
            <!-- Header for Chat Section -->
            <h3 class="text-xl font-semibold mb-4 text-white">Komentar</h3>

            <!-- Input Field for New Messages -->
            <div class="flex items-center space-x-2 mb-4">
                <img src="https://www.shutterstock.com/image-photo/asian-man-wearing-traditional-javanese-260nw-2200692029.jpg" alt="Profile image" class="w-8 h-8 rounded-full bg-gray-300">
                <input type="text" id="chatInput" placeholder="Ketik pesan..." class="flex-grow py-2 px-3 border-b-2 border-gray-500 bg-transparent text-white focus:outline-none focus:border-red-700">
                <button id="sendButton" class="p-2 bg-red-700 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-700">Kirim</button>
            </div>

            <!-- Chat Messages -->
            <div id="chat-messages" class="bg-gray-600 p-4 rounded-lg shadow-lg overflow-y-auto max-h-[300px] text-left flex-grow">
                <!-- Pesan dari Pengguna Lain -->
                <div class="message flex items-start gap-2.5 mb-4 relative other-user">
                    <img class="w-8 h-8 rounded-full" src="https://www.shutterstock.com/image-photo/asian-man-wearing-traditional-javanese-260nw-2200692029.jpg" alt="Profile image">
                    <div class="flex flex-col w-full max-w-[320px] leading-1.5 p-4 border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl dark:bg-gray-700">
                        <div class="flex items-center space-x-2 rtl:space-x-reverse">
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">Bonnie Green</span>
                            <span class="text-sm font-normal text-gray-500 dark:text-gray-400">1 menit yang lalu</span>
                        </div>
                        <p class="text-sm font-normal py-2.5 text-gray-900 dark:text-white message-text">That's awesome. I think our users will really appreciate the improvements.</p>
                        <!-- Add Like, Dislike, and Reply Controls -->
                        <div class="flex items-center space-x-4 mt-2 text-gray-400">
                            <button class="flex items-center space-x-1 hover:text-gray-200">
                                <i class='bx bx-like'></i>
                                <span class="text-xs">Like</span>
                            </button>
                            <button class="flex items-center space-x-1 hover:text-gray-200">
                                <i class='bx bx-dislike'></i>
                                <span class="text-xs">Dislike</span>
                            </button>
                            <button class="flex items-center space-x-1 hover:text-gray-200">
                                <i class='bx bx-reply'></i>
                                <span class="text-xs">Reply</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Pesan Pengguna Sendiri -->
                <div class="message flex items-start gap-2.5 mb-4 relative self-user">
                    <div class="flex flex-col w-full max-w-[320px] leading-1.5 p-4 border-gray-200 bg-blue-500 text-white rounded-s-xl rounded-se-xl dark:bg-blue-700">
                        <div class="flex items-center space-x-2 rtl:space-x-reverse">
                            <span class="text-sm font-semibold">Anda</span>
                            <span class="text-sm font-normal">1 menit yang lalu</span>
                        </div>
                        <p class="text-sm font-normal py-2.5 message-text">Ini pesan saya.</p>
                        <!-- Add Like, Dislike, and Reply Controls -->
                        <div class="flex items-center space-x-4 mt-2 text-gray-100">
                            <button class="flex items-center space-x-1 hover:text-gray-100">
                                <i class='bx bx-like'></i>
                                <span class="text-xs">Like</span>
                            </button>
                            <button class="flex items-center space-x-1 hover:text-white">
                                <i class='bx bx-dislike'></i>
                                <span class="text-xs">Dislike</span>
                            </button>
                            <button class="flex items-center space-x-1 hover:text-gray-200">
                                <i class='bx bx-reply'></i>
                                <span class="text-xs">Reply</span>
                            </button>
                        </div>
                    </div>
                    <img class="w-8 h-8 rounded-full ml-2" src="https://www.shutterstock.com/image-photo/asian-man-wearing-traditional-javanese-260nw-2200692029.jpg" alt="Profile image">
                </div>
            </div>
        </div>

    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // Konfigurasi Video
            const video = document.getElementById('video');
            const durationLabel = document.getElementById('durationLabel');

            function updateDurationLabel() {
                const minutes = Math.floor(video.currentTime / 60);
                const seconds = Math.floor(video.currentTime % 60);
                durationLabel.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            }

            video.addEventListener('timeupdate', updateDurationLabel);
            video.addEventListener('loadedmetadata', function() {
                const totalMinutes = Math.floor(video.duration / 60);
                const totalSeconds = Math.floor(video.duration % 60);
                durationLabel.textContent = `${totalMinutes}:${totalSeconds < 10 ? '0' : ''}${totalSeconds}`;
            });


            // Konfigurasi Deskripsi Baca Selengkapnya
            const deskripsiElement = document.getElementById('deskripsi-part1');
            const deskripsiPart2Element = document.getElementById('deskripsi-part2');
            const readMoreDeskripsiButton = document.getElementById('read-more-deskripsi');
            const maxLines = 5;
            const lineHeight = 1.5;
            const maxHeight = `${maxLines * lineHeight}em`;

            deskripsiElement.innerText = `{{$detail->deskripsi}}`;
            deskripsiElement.style.maxHeight = maxHeight;
            deskripsiElement.style.overflow = 'hidden';

            if (deskripsiElement.scrollHeight > deskripsiElement.clientHeight) {
                const words = deskripsiElement.innerText.split(' ');
                let paragraph1 = '';
                let paragraph2 = '';
                let tempText = '';

                for (let i = 0; i < words.length; i++) {
                    tempText += words[i] + ' ';
                    deskripsiElement.innerText = tempText.trim();

                    if (deskripsiElement.scrollHeight > deskripsiElement.clientHeight) {
                        paragraph1 = tempText.trim();
                        paragraph2 = words.slice(i).join(' ');
                        break;
                    }
                }

                deskripsiElement.innerText = paragraph1;
                deskripsiPart2Element.innerText = paragraph2;
                readMoreDeskripsiButton.classList.remove('hidden');
            }

            readMoreDeskripsiButton.addEventListener('click', function() {
                if (deskripsiPart2Element.classList.contains('hidden')) {
                    deskripsiPart2Element.classList.remove('hidden');
                    readMoreDeskripsiButton.textContent = 'Tampilkan Lebih Sedikit';
                } else {
                    deskripsiPart2Element.classList.add('hidden');
                    readMoreDeskripsiButton.textContent = 'Baca Selengkapnya';
                }
            });
        });
    </script>

</body>

</html>