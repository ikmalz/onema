<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail</title>
    <link rel="icon" href="../asset/foto/logoonema.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href='https://unpkg.com/boxicons/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

    .message img {
        border-radius: 50%;
    }

    .message.self-user {
        justify-content: flex-start;
    }

    .message.self-user img {
        order: -1;
    }

    .message.self-user .message-text {
        background-color: transparent;
        color: white;
    }

    .message.other-user {
        justify-content: flex-start;
    }

    .message.other-user img {
        order: -1;
    }

    .message.other-user .message-text {
        background-color: transparent;
        color: white;
    }

    .replies .reply-item img {
        order: -1;
    }

    #reply-item replies {
        order: -1;
    }

    .text-container {
        max-height: 7.5em;
        overflow: hidden;
    }

    .text-ellipsis {
        max-height: 7.5em;
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

    button {
        background: none;
        border: none;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    button:focus {
        outline: none;
    }

    button i {
        font-size: 1.5rem;
    }

    .self-user {
        justify-content: flex-end;
    }

    .other-user {
        justify-content: flex-start;
    }

    #sinopsis-container p {
        margin: 0;
        padding-bottom: 0.6rem;
    }


    #video-container {
        position: relative;
        text-align: center;
        /* Center the video */
    }

    #like-dislike-container {
        margin-top: 10px;
        justify-content: flex-start;
        /* Align buttons to the left */
        width: 80%;
        /* Match the width of the video */
        margin-left: auto;
        margin-right: auto;
        /* Center the container horizontally */
    }

    #like-btn,
    #dislike-btn {
        display: flex;
        align-items: center;
    }

    .bx-like,
    .bx-dislike {
        font-size: 1.5rem;
        cursor: pointer;
    }

    /* Style for hovered empty stars */
    .empty-star:hover,
    .empty-star:hover~.empty-star {
        color: yellow;
    }

    /* Default color for empty stars */
    .empty-star {
        color: gray;
        transition: color 0.3s ease;
    }

    /* Selected stars (those that have been rated) */
    .selected {
        color: yellow;
    }

    /* Optional: Prevent filled stars from changing color on hover */
    .selected:hover {
        color: yellow !important;
    }

    #star-rating {
        display: flex;
        flex-direction: row-reverse;
        /* Membalikkan urutan bintang */
    }

    #star-rating svg {
        position: relative;
    }

    #star-rating svg::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 50%;
        height: 100%;
        background: yellow;
        clip-path: inset(0 0 0 0);
        z-index: 1;
    }

    #star-rating svg path {
        position: relative;
        z-index: 0;
    }

    #star-rating svg {
        cursor: pointer;
        transition: fill 0.2s ease;
    }

    #star-rating svg:hover,
    #star-rating svg.hovered {
        fill: #FFD700;
        /* Warna kuning saat hover */
    }

    #delete-rating-icon {
        position: relative;
        top: -20px;
        left: 20px;
        width: 16px;
        height: 16px;
        cursor: pointer;
    }
</style>

<body>
    <header class="bg-[#E52B09] shadow-md" style="box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);">
        <div class="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-12">
                    <a href="{{ route('home') }}" class="flex items-center text-white hover:text-gray-400">
                        <i class='bx bxs-left-arrow-alt text-4xl'></i>
                    </a>
                    <a class="block text-teal-600" href="#">
                        <span class="sr-only">Home</span>
                        <img src="../asset/foto/logoonema.png" alt="Logo" class="w-20 h-20 ">
                    </a>

                </div>

                <div class="hidden md:flex items-center flex-grow ml-8">
                    <div class="relative flex items-center max-w-full w-full">


                        <div class="relative flex-1 flex items-center">
                            <input type="text" class="pl-10 pr-12 py-2 text-sm border rounded-md h-full w-full" placeholder="Search..." />
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
            <video id="video" class="video-size rounded-lg" controls autoplay>
                <source src="{{ asset('upload/' . $detail->vidio) }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>

        <!-- Like and Dislike Buttons -->
        <div id="like-dislike-container" class="flex items-center p-3">
            @auth
            <button id="like-btn" class="like-icon mr-4" data-id="{{ $detail->id }}">
                <i class='bx bx-like text-2xl {{ $detail->isLiked() ? 'text-red-500' : 'text-gray-500' }}'></i>
            </button>

            <button id="dislike-btn" class="dislike-icon" data-id="{{ $detail->id }}">
                <i class='bx bx-dislike text-2xl {{ $detail->isDisliked() ? 'text-blue-500' : 'text-gray-500' }}'></i>
            </button>
            @else
            <button class="mr-4 text-gray-500" disabled>
                <i class='bx bx-like text-2xl'></i>
            </button>
            <button class="text-gray-500" disabled>
                <i class='bx bx-dislike text-2xl'></i>
            </button>
            @endauth
        </div>

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
                <div class="md:mb-4">
                    <h2 class="text-4xl font-bold mb-2">{{$detail->title}}</h2>
                    <p class="text-sm mb-1">Tanggal Publish: {{$detail->tahun}}</p>
                    <p class="text-sm mb-1">Genre: {{$detail->populer}}</p>
                    <div class="bg-gray-800 pl-7 pr-8 py-4 w-full max-w-3xl mx-auto">
                        <hr class="border-gray-600 my-4">
                        <div class="flex items-center justify-between">
                            <p class="text-xl text-justify text-white font-bold pb-1">Rating</p>

                            <!-- Icon titik tiga (ellipsis) -->
                            <div class="relative">
                                <button id="ellipsis-btn" class="text-white focus:outline-none">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 10.75a1.25 1.25 0 100-2.5 1.25 1.25 0 000 2.5zM6 10.75a1.25 1.25 0 100-2.5 1.25 1.25 0 000 2.5zM18 10.75a1.25 1.25 0 100-2.5 1.25 1.25 0 000 2.5z" />
                                    </svg>
                                </button>

                                <!-- Tombol Hapus di Pop-up -->
                                <div id="popup-menu" class="absolute right-0 mt-2 w-24 bg-white text-black rounded-md shadow-lg hidden z-50">
                                    <ul>
                                        <li>
                                            <button id="delete-rating-btn" class="w-full px-4 py-2 text-left hover:bg-red-500 hover:rounded-md hover:text-white">
                                                Hapus
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Rating Stars -->
                        <!-- Bintang Rating -->
                        <div class="flex items-center text-white">
                            @php
                            $averageRating = $detail->averageRating(); // Menghitung rata-rata rating
                            $fullStars = floor($averageRating); // Bintang penuh
                            $halfStar = $averageRating - $fullStars >= 0.5 ? true : false; // Setengah bintang
                            $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0); // Bintang kosong
                            @endphp

                            <!-- Tampilkan bintang penuh -->
                            @for ($i = 0; $i < $fullStars; $i++)
                                <svg class="w-4 h-4 text-yellow-300 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                </svg>
                                @endfor

                                <!-- Tampilkan setengah bintang (jika ada) -->
                                @if ($halfStar)
                                <svg class="w-4 h-4 text-yellow-300 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                    <path d="M11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                    <path d="M7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" fill="none" stroke="currentColor" stroke-width="1.5" />
                                </svg>
                                @endif

                                <!-- Tampilkan bintang kosong -->
                                @for ($i = 0; $i < $emptyStars; $i++)
                                    <svg class="w-4 h-4 text-gray-300 me-1 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                    </svg>
                                    @endfor

                                    <!-- Tampilkan nilai rating -->
                                    <div class="flex items-center text-white">
                                        <p class="average-rating">{{ number_format($averageRating, 2) }}</p>
                                        <p class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400">out of 5</p>
                                    </div>
                        </div>


                        <!-- Bintang rating jika user belum memberikan rating -->
                        @if (auth()->check() && !$userHasRated)
                        <div id="star-rating" class="flex items-center my-2">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg data-value="{{ $i }}" class="w-8 h-8 text-gray-400 cursor-pointer empty-star hover:text-yellow-300 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <defs>
                                    <linearGradient id="grad{{ $i }}" x1="0%" y1="0%" x2="100%">
                                        <stop offset="0%" style="stop-color:yellow;stop-opacity:1" />
                                        <stop offset="0%" style="stop-color:gray;stop-opacity:1" />
                                    </linearGradient>
                                </defs>
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 22 12 18.67 5.82 22 7 14.14l-5-4.87 6.91-1.01L12 2z" />
                                </svg>
                                @endfor
                        </div>
                        @elseif(auth()->guest())
                        <p class="text-gray-400">Login untuk memberikan rating.</p>
                        @endif

                        <!-- Hidden Form -->
                        <form id="rating-form" action="{{ route('video.rate', $detail->id) }}" method="POST" class="hidden">
                            @csrf
                            <input type="hidden" name="rating" id="rating-value">
                        </form>

                        <hr class="border-gray-600 my-4">
                    </div>
                </div>
            </div>

        </div>

        <!-- Deskripsi Section -->
        <div class="bg-gray-800 pl-7 pr-8 py-4 w-full max-w-3xl mx-auto ">
            <hr class="border-gray-600 my-4">
            <p class="text-xl text-justify text-white font-bold pb-1">Sinopsis</p>
            <div id="sinopsis-container" class="text-wrap text-sm text-justify text-white overflow-hidden" style="max-height: 100px;">
                @foreach (explode("\n", $detail->deskripsi) as $paragraph)
                <p class="paragraph">{{ $paragraph }}</p>
                @endforeach
            </div>
            <button id="toggle-sinopsis" class="text-red-600 hover:underline mt-1">Selengkapnya</button>
            <hr class="border-gray-600 my-4">
        </div>

        <!-- Chat Section -->
        <div id="chat-container" class="w-full max-w-3xl mx-auto bg-black p-4 rounded-b-lg flex flex-col h-full bg-[linear-gradient(to_bottom,_rgba(31,41,55,1)_0%,_rgba(31,41,55,0)_40%)]">
            <h3 class="text-xl font-semibold mb-4 text-white">Komentar</h3>

            @auth
            <form id="comment-form" action="{{ route('comment.store', $detail->id) }}" method="POST" class="flex items-center mb-4">
                @csrf
                <input type="text" name="comment" placeholder="Tulis komentar..." class="flex-grow py-2 px-3 border-b-2 border-gray-500 bg-transparent text-white focus:border-red-700 focus:outline-none placeholder-gray-400" required>
                <button type="submit" class="ml-4 p-2 bg-red-700 text-white rounded-lg hover:bg-red-800 focus:ring focus:ring-red-500 focus:ring-opacity-50">Kirim</button>
            </form>
            @else
            <p class="text-gray-400 py-5">Login untuk menulis komentar.</p>
            @endauth


            <!-- Chat Messages -->
            <div id="chat-messages" class="text-left flex-grow overflow-y-auto max-h-[300px]">
                @if($comments && $comments->count() > 0)
                @foreach ($comments as $comment)
                <!-- Komentar Utama -->
                <div class="message flex items-start gap-2.5 mb-4 relative {{ $comment->user_id == auth()->id() ? 'self-user' : 'other-user' }}" data-id="{{ $comment->id }}">
                    @if ($comment->user_id == auth()->id())
                    <!-- Komentar Sendiri -->
                    <img class="w-8 h-8 rounded-full" src="{{ Auth::user()->profile_photo_path 
                            ? asset('storage/' . Auth::user()->profile_photo_path) 
                            : 'https://static.vecteezy.com/system/resources/thumbnails/005/129/844/small_2x/profile-user-icon-isolated-on-white-background-eps10-free-vector.jpg' }}" alt="Profile image">
                    <div class="flex flex-col w-full max-w-[320px] leading-1.5 p-2 bg-transparent text-white">
                        <div class="flex items-center space-x-2 rtl:space-x-reverse">
                            <span class="text-sm font-semibold">Anda</span>
                            <span class="text-sm font-light">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm font-light py-1">{{ $comment->comment }}</p>
                        <div class="flex items-center space-x-3 mt-2">
                            <button class="like-btn" data-id="{{ $comment->id }}">
                                <i class="bx bx-like text-lg {{ $comment->likes->contains('user_id', auth()->id()) ? 'text-red-600' : '' }}"></i>
                            </button>
                            <span class="like-count">{{ $comment->likes->count() }}</span>

                            <button class="dislike-btn" data-id="{{ $comment->id }}">
                                <i class="bx bx-dislike text-lg {{ $comment->dislikes->contains('user_id', auth()->id()) ? 'text-red-600' : '' }}"></i>
                            </button>
                            <span class="dislike-count">{{ $comment->dislikes->count() }}</span>

                            <button class="reply-btn" data-id="{{ $comment->id }}">
                                <div class="text-sm">Balas</div>
                            </button>
                        </div>

                    </div>
                    @else
                    <!-- Komentar Orang Lain -->
                    <img class="w-8 h-8 rounded-full" src="{{ $comment->user->profile_photo_path 
                            ? asset('storage/' . $comment->user->profile_photo_path) 
                            : 'https://static.vecteezy.com/system/resources/thumbnails/005/129/844/small_2x/profile-user-icon-isolated-on-white-background-eps10-free-vector.jpg' }}" alt="Profile image">
                    <div class="flex flex-col w-full max-w-[320px] leading-1.5 p-2 bg-transparent text-white">
                        <div class="flex items-center space-x-2 rtl:space-x-reverse">
                            <span class="text-sm font-light">@ {{ $comment->user->username }}</span>
                            <span class="text-sm font-light">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm font-normal py-1">{{ $comment->comment }}</p>
                        <div class="flex items-center space-x-3 mt-2">
                            <button class="like-btn" data-id="{{ $comment->id }}">
                                <i class="bx bx-like text-lg {{ $comment->likes->contains('user_id', auth()->id()) ? 'text-red-600' : '' }}"></i>
                            </button>
                            <span class="like-count">{{ $comment->likes->count() }}</span>

                            <button class="dislike-btn" data-id="{{ $comment->id }}">
                                <i class="bx bx-dislike text-lg {{ $comment->dislikes->contains('user_id', auth()->id()) ? 'text-red-600' : '' }}"></i>
                            </button>
                            <span class="dislike-count">{{ $comment->dislikes->count() }}</span>

                            <button class="reply-btn" data-id="{{ $comment->id }}">
                                <div class="text-sm">Balas</div>
                            </button>
                        </div>

                    </div>
                    @endif
                </div>

                <!-- Balasan Komentar -->
                @if($comment->replies && $comment->replies->count() > 0)
                <div class="replies p-2 ml-12">
                    @foreach ($comment->replies as $reply)
                    <div class="reply-item flex items-start gap-2.5 p-1 mb-1">
                        <img class="w-6 h-6 rounded-full" src="{{ $reply->user->profile_photo_path 
                            ? asset('storage/' . $reply->user->profile_photo_path) 
                            : 'https://static.vecteezy.com/system/resources/thumbnails/005/129/844/small_2x/profile-user-icon-isolated-on-white-background-eps10-free-vector.jpg' }}" alt="Profile image">
                        <div class="flex flex-col text-white">

                            <div class="flex items-center justify-between py-2">
                                <span class="text-sm font-semibold text-white">{{ $reply->user->username }}</span>
                                <span class="text-xs text-gray-400 pl-2">{{ $reply->created_at->diffForHumans() }}</span>
                            </div>
                            <span class="text-sm">{{ $reply->reply }}</span>
                            <div class="flex items-center space-x-3 mt-2">
                                <button class="like-btn" data-id="{{ $comment->id }}">
                                    <i class="bx bx-like text-lg {{ $comment->likes->contains('user_id', auth()->id()) ? 'text-red-600' : '' }}"></i>
                                </button>
                                <span class="like-count">{{ $comment->likes->count() }}</span>

                                <button class="dislike-btn" data-id="{{ $comment->id }}">
                                    <i class="bx bx-dislike text-lg {{ $comment->dislikes->contains('user_id', auth()->id()) ? 'text-red-600' : '' }}"></i>
                                </button>
                                <span class="dislike-count">{{ $comment->dislikes->count() }}</span>

                                <button class="reply-btn" data-id="{{ $comment->id }}">
                                    <div class="text-sm">Balas</div>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                <div class="reply-form hidden mt-2" id="reply-form-{{ $comment->id }}">
                    <form class="flex items-center w-full mb-2 reply-form" data-id="{{ $comment->id }}">
                        @csrf
                        <input type="text" name="reply" placeholder="Tulis balasan..." class="flex-grow py-2 px-3 border-b-2 border-gray-500 bg-transparent text-white focus:border-red-700 reply-input">
                        <button type="submit" class="ml-4 p-2 bg-red-700 text-white rounded-lg hover:bg-red-800 focus:ring-red-700 send-reply-btn" data-id="{{ $comment->id }}">Kirim</button>
                        <button type="button" class="ml-2 p-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 cancel-reply-btn" data-id="{{ $comment->id }}">Batal</button>
                    </form>
                </div>

                @endforeach
                @else
                <p class="text-white">Belum ada komentar.</p>
                @endif
            </div>
        </div>

    </section>


    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // Pop up hapus
            document.getElementById('ellipsis-btn').addEventListener('click', function() {
                var popup = document.getElementById('popup-menu');
                popup.classList.toggle('hidden');
            });

            window.addEventListener('click', function(event) {
                var popup = document.getElementById('popup-menu');
                var ellipsisBtn = document.getElementById('ellipsis-btn');

                if (!popup.contains(event.target) && !ellipsisBtn.contains(event.target)) {
                    popup.classList.add('hidden');
                }
            });

            // Hapus Rating
            document.getElementById('delete-rating-btn').addEventListener('click', function() {
                fetch('/video/{{ $detail->id }}/delete-rating', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Rating berhasil dihapus!');

                            // Menyembunyikan bintang rating setelah dihapus
                            document.getElementById('star-rating').style.display = 'block';

                            // Refresh tampilan untuk menampilkan rating yang terbaru
                            location.reload(); // Menyegarkan halaman untuk memperbarui tampilan
                        } else {
                            alert('Gagal menghapus rating!');
                        }

                        // Sembunyikan pop-up
                        var popup = document.getElementById('popup-menu');
                        popup.classList.add('hidden');
                    })
                    .catch(error => console.error('Error:', error));
            });


            //hover rating
            const stars = document.querySelectorAll('#star-rating .empty-star');

            stars.forEach((star, index) => {
                // On hover
                star.addEventListener('mouseenter', function() {
                    highlightStars(index);
                });

                // Reset when mouse leaves
                star.addEventListener('mouseleave', function() {
                    resetStars();
                });

                // On click, select the stars and submit the rating
                star.addEventListener('click', function() {
                    selectStars(index);
                });
            });

            // Function to highlight stars on hover
            function highlightStars(index) {
                stars.forEach((star, i) => {
                    if (i <= index) {
                        star.classList.add('selected');
                    } else {
                        star.classList.remove('selected');
                    }
                });
            }

            // Function to reset stars when not hovering
            function resetStars() {
                stars.forEach(star => {
                    star.classList.remove('selected');
                });
            }

            // Function to select and submit the stars
            function selectStars(index) {
                document.getElementById('rating-value').value = index + 1;
                stars.forEach((star, i) => {
                    if (i <= index) {
                        star.classList.add('selected');
                    } else {
                        star.classList.remove('selected');
                    }
                });
            }



            // Rating
            document.querySelectorAll('#star-rating svg').forEach(star => {
                star.addEventListener('click', function() {
                    const rating = this.getAttribute('data-value');
                    // Hapus kelas 'active' dari semua bintang
                    document.querySelectorAll('#star-rating svg').forEach(s => s.classList.remove('active'));
                    // Tambahkan kelas 'active' untuk bintang yang dipilih dan semua bintang sebelumnya
                    document.querySelectorAll('#star-rating svg').forEach((s, index) => {
                        if (index < rating) {
                            s.classList.add('active');
                        }
                    });

                    fetch('/video/{{ $detail->id }}/rate', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                rating: rating
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.message === 'Anda sudah memberikan rating untuk video ini.') {
                                alert('Anda sudah memberikan rating untuk video ini.');
                            } else {
                                alert('Terima kasih atas rating Anda!');

                                // Update rata-rata rating di tampilan
                                const averageRatingElement = document.querySelector('.average-rating');
                                if (averageRatingElement) {
                                    averageRatingElement.textContent = parseFloat(data.averageRating).toFixed(2);
                                }

                                // Reload halaman setelah rating berhasil diberikan
                                location.reload();
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan saat mengirim rating.');
                        });
                });
            });






            $(document).ready(function() {
                $('#like-btn').on('click', function() {
                    let videoId = $(this).data('id');
                    $.ajax({
                        url: '/video/' + videoId + '/like',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status === 'liked') {
                                $('#like-btn i').removeClass('text-gray-500').addClass('text-red-500');
                            } else {
                                $('#like-btn i').removeClass('text-red-500').addClass('text-gray-500');
                            }
                        }
                    });
                });

                $('#dislike-btn').on('click', function() {
                    let videoId = $(this).data('id');
                    $.ajax({
                        url: '/video/' + videoId + '/dislike',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status === 'disliked') {
                                $('#dislike-btn i').removeClass('text-gray-500').addClass('text-blue-500');
                            } else {
                                $('#dislike-btn i').removeClass('text-blue-500').addClass('text-gray-500');
                            }
                        }
                    });
                });
            });


            // comment
            $('#comment-form').submit(function(event) {
                event.preventDefault();
                let formData = $(this).serialize();

                $.ajax({
                    method: "POST",
                    url: $(this).attr('action'),
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Menghapus pesan "Belum ada komentar" jika ada
                        $('.no-comments').remove();

                        const newComment = `
                <div class="message flex items-start gap-2.5 mb-4 relative self-user">
                    <img class="w-8 h-8 rounded-full" src="${response.profile_photo}" alt="Profile image">
                    <div class="flex flex-col w-full max-w-[320px] leading-1.5 p-2 bg-transparent text-white">
                        <div class="flex items-center space-x-2 rtl:space-x-reverse">
                            <span class="text-sm font-semibold">${response.user_name}</span>
                            <span class="text-sm font-light">${response.created_at}</span>
                        </div>
                        <p class="text-sm font-light py-1">${response.comment}</p>
                        <div class="flex items-center space-x-3 mt-2">
                            <button class="like-btn" data-id="${response.comment_id}">
                                <i class="bx bx-like text-lg"></i>
                            </button>
                            <span class="like-count">0</span>

                            <button class="dislike-btn" data-id="${response.comment_id}">
                                <i class="bx bx-dislike text-lg"></i>
                            </button>
                            <span class="dislike-count">0</span>

                            <button class="reply-btn" data-id="${response.comment_id}">
                                <div class="text-sm">Balas</div>
                            </button>
                        </div>
                    </div>
                </div>
            `;

                        $('#chat-messages').append(newComment);
                        $('#comment-form')[0].reset();

                        // Refresh halaman setelah komentar dikirim
                        location.reload(); // Tambahkan ini untuk refresh halaman
                    },
                    error: function(xhr) {
                        console.error('Gagal mengirim komentar:', xhr.statusText);
                    }
                });
            });





            // Untuk like button
            $('.like-btn').on('click', function() {
                let commentId = $(this).data('id');
                let likeButton = $(this);
                let dislikeButton = likeButton.closest('.message').find('.dislike-btn');
                let likeCountSpan = likeButton.next('.like-count');
                let dislikeCountSpan = dislikeButton.next('.dislike-count');

                $.ajax({
                    method: "POST",
                    url: `/comment/${commentId}/like`,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response.message);

                        // Update UI untuk like
                        if (response.status === 'liked') {
                            likeButton.find('i').addClass('text-red-600');
                            dislikeButton.find('i').removeClass('text-red-600'); // Hapus warna dislike jika ada
                        } else {
                            likeButton.find('i').removeClass('text-red-600');
                        }

                        // Update jumlah like dan dislike
                        likeCountSpan.text(response.likeCount);
                        dislikeCountSpan.text(response.dislikeCount);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });

            // Untuk dislike button
            $('.dislike-btn').on('click', function() {
                let commentId = $(this).data('id');
                let dislikeButton = $(this);
                let likeButton = dislikeButton.closest('.message').find('.like-btn');
                let dislikeCountSpan = dislikeButton.next('.dislike-count');
                let likeCountSpan = likeButton.next('.like-count');

                $.ajax({
                    method: "POST",
                    url: `/comment/${commentId}/dislike`,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response.message);

                        // Update UI untuk dislike
                        if (response.status === 'disliked') {
                            dislikeButton.find('i').addClass('text-red-600');
                            likeButton.find('i').removeClass('text-red-600'); // Hapus warna like jika ada
                        } else {
                            dislikeButton.find('i').removeClass('text-red-600');
                        }

                        // Update jumlah like dan dislike
                        dislikeCountSpan.text(response.dislikeCount);
                        likeCountSpan.text(response.likeCount);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });





            // Toggle reply form visibility when 'Balas' button is clicked
            $(document).on('click', '.reply-btn', function() {
                let commentId = $(this).data('id');

                // Toggle the reply form visibility
                $('#reply-form-' + commentId).toggleClass('hidden');
            });

            // Handle the cancel button click
            $(document).on('click', '.cancel-reply-btn', function() {
                let commentId = $(this).data('id');

                // Hide the reply form
                $('#reply-form-' + commentId).addClass('hidden');
            });

            // Handle sending the reply
            $(document).on('submit', '.reply-form', function(event) {
                event.preventDefault(); // Prevent form from submitting normally

                let form = $(this);
                let commentId = form.data('id');
                let replyInput = form.find('.reply-input').val();

                if (replyInput.trim() === "") {
                    alert('Balasan tidak boleh kosong!');
                    return;
                }

                $.ajax({
                    method: "POST",
                    url: `/comment/${commentId}/reply`,
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        reply: replyInput
                    },
                    success: function(response) {
                        // Append the new reply before the form
                        const newReply = `
                                    <div class="replies p-2 ml-12">

                    <div class="reply-item flex items-start gap-2.5 p-1 mb-1">
            <img class="w-6 h-6 rounded-full" src="${response.profile_photo_path ? response.profile_photo_path : 'https://static.vecteezy.com/system/resources/thumbnails/005/129/844/small_2x/profile-user-icon-isolated-on-white-background-eps10-free-vector.jpg'}" alt="Profile image">
                    <div class="flex flex-col text-white">
                        <div class="flex items-center justify-between py-2">
                            <span class="text-sm font-semibold text-white">${response.user_name}</span>
                            <span class="text-xs text-gray-400 pl-2">Baru saja</span>
                        </div>
                        <span class="text-sm">${response.reply}</span>
                        <div class="flex items-center space-x-3 mt-2">
                    <button class="like-btn" data-id="${response.reply_id}">
                        <i class="bx bx-like text-lg"></i>
                    </button>
                    <span class="like-count">0</span> <!-- Ganti dengan logika jumlah like sesuai kebutuhan -->

                    <button class="dislike-btn" data-id="${response.reply_id}">
                        <i class="bx bx-dislike text-lg"></i>
                    </button>
                    <span class="dislike-count">0</span> <!-- Ganti dengan logika jumlah dislike sesuai kebutuhan -->
                </div>
                    </div>
                </div>
                </div>
            `;
                        form.before(newReply); // Append the new reply before the form
                        form.find('.reply-input').val(''); // Clear the input field
                        form.addClass('hidden'); // Hide the form after submission
                    },
                    error: function(xhr) {
                        console.error('Gagal mengirim balasan:', xhr.statusText);
                    }
                });
            });

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

            //rating

        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var container = document.getElementById('sinopsis-container');
            var toggleButton = document.getElementById('toggle-sinopsis');

            var maxHeight = 100;
            var fullHeight = container.scrollHeight;

            if (fullHeight > maxHeight) {
                toggleButton.style.display = 'block';
            } else {
                toggleButton.style.display = 'none';
            }
        });


        function toggleSinopsis() {
            var container = document.getElementById('sinopsis-container');
            var toggleButton = document.getElementById('toggle-sinopsis');

            if (container.style.maxHeight === '100px') {
                container.style.maxHeight = 'none';
                container.style.overflow = 'visible';
                toggleButton.innerText = "Lebih Sedikit";
            } else {
                container.style.maxHeight = '100px';
                container.style.overflow = 'hidden';
                toggleButton.innerText = "Selengkapnya";
            }
        }

        document.getElementById('toggle-sinopsis').addEventListener('click', toggleSinopsis);
    </script>
</body>

</html>