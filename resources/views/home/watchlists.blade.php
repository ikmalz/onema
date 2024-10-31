<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Watchlist</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <link rel="icon" href="../asset/foto/logoonema.png" type="image/png">
  <style>
    .fade-in {
      transform: scale(0.8);
      opacity: 0;
      transition: transform 0.4s ease, opacity 0.4s ease;
    }

    .fade-in.visible {
      transform: scale(1);
      opacity: 1;
    }

    .slide-up {
      transform: translateY(20px);
      opacity: 0;
      transition: transform 0.5s ease-out, opacity 0.5s ease-out;
    }

    .slide-up.visible {
      transform: translateY(0);
      opacity: 1;
    }
  </style>
</head>

<body>

  <!--header-->
  <header class="bg-[#E52B09] sticky top-0 z-50">
    <div class="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
          <a class="block text-teal-600" href="{{ route('homepage') }}">
            <span class="sr-only">Home</span>
            <img src="../asset/foto/logoonema.png" alt="Logo" class="w-20 h-20">
          </a>
        </div>

        <div class="hidden md:flex items-center flex-grow ml-4">
          <div class="relative flex items-center max-w-full w-full">
            <button id="dropdownButton" class="relative bg-gray-300 px-4 text-sm font-medium text-gray-700 rounded-l-md flex items-center h-10 py-2" style="padding-top: 9px; padding-bottom: 9px;">
              All
              <i id="dropdownArrow" class='bx bx-chevron-down h-4 w-4 ml-2 transition-transform duration-300'></i>
            </button>

            <div id="dropdownMenu" class="dropdown-menu rounded-md shadow-lg hidden absolute mt-2 bg-white">
              <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100"><i class='bx bx-search-alt-2'></i> All</a>
              <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100"><i class='bx bxs-detail'></i> Titles</a>
              <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100"><i class='bx bx-tv'></i> TV Episodes</a>
            </div>

            <div class="relative flex-1 flex items-center">
              <input id="search-input" type="text" class="pl-10 pr-12 py-2 text-sm border rounded-r-md h-10 w-full" placeholder="Search..." />
              <i class='bx bx-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 font-2xl'></i>

              <div id="suggestions" class="absolute top-full left-0 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg hidden z-50">

              </div>

              <div id="search-history" class="absolute top-full left-0 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg hidden z-50">

              </div>
            </div>

            <div class="flex items-center ml-4">
              <a id="menu-link" href="#" class="flex items-center">
                <i class='bx bx-menu text-black font-bold' style="font-size: 30px;"></i>
                <span class="text-white font-semibold text-sm ml-2">Menu</span>
              </a>
              <div class="h-6 border-l border-gray-400 mx-2"></div>
              <a href="{{ route('watchlists') }}" class="flex items-center">
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
        </div>
      </div>
    </div>
  </header>
  <!--end header-->

  <!-- Watchlist Section -->
  <section id="content" class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
    @if(request()->get('login_required'))
    <div class="alert alert-warning text-center">
      <p class="text-gray-500">Anda perlu <a href="{{ route('login') }}" class="text-blue-600 underline">login</a> untuk melihat watchlist Anda.</p>
    </div>
    @endif

    @if(auth()->check())
    <ul class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
      @forelse ($watchlistItems as $item)
      @if ($item->trailer)
      <li class="relative fade-in overflow-hidden rounded" style="display: none;">
        <a href="{{ route('home.detail', $item->trailer->id) }}" class="group block">
          <img src="{{ asset('upload/' . $item->trailer->poster) }}" alt="{{ $item->trailer->title }}" class="h-[250px] w-full object-cover transition rounded-md duration-500 group-hover:scale-105 sm:h-[400px]" />
          <div class="relative bg-white pt-2 px-2">
            <h3 class="text-sm font-semibold text-gray-800 group-hover:underline group-hover:underline-offset-4">
              {{ $item->trailer->title }}
            </h3>
            <p class="mt-1 text-xs text-gray-600">
              {{ Str::limit($item->trailer->deskripsi, 50) }}
            </p>
          </div>
        </a>
      </li>
      @else
      <li>
        <p class="text-center text-gray-500">Trailer tidak tersedia.</p>
      </li>
      @endif
      @empty
      <li>
        <p class="text-center text-gray-500">Your watchlist is empty.</p>
      </li>
      @endforelse

    </ul>
    @else
    <p class="text-center text-gray-500">Anda harus login untuk melihat isi watchlist.</p>
    @endif
  </section>



  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const items = document.querySelectorAll(".fade-in");

      items.forEach((item, index) => {
        setTimeout(() => {
          item.style.display = "block";
          item.classList.add("visible"); 
        }, index * 100); 
      });

      //  pencarian
      document.getElementById("search-input").addEventListener("input", function() {
        const query = this.value.toLowerCase();
        const items = document.querySelectorAll("ul li.fade-in");

        let found = false;

        items.forEach(item => {
          const title = item.querySelector("h3").textContent.toLowerCase();
          if (title.includes(query)) {
            item.style.display = "block";
            item.classList.add("visible"); 
            found = true; 
          } else {
            item.style.display = "none";
            item.classList.remove("visible");
          }
        });

        if (!found) {
          items.forEach(item => {
            item.style.display = "none";
            item.classList.remove("visible");
          });
        }
      });
    });
  </script>

</body>

</html>