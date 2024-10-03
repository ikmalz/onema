<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Watchlist</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .loader {
      border: 8px solid #f3f3f3; /* Light grey */
      border-top: 8px solid #3498db; /* Blue */
      border-radius: 50%;
      width: 50px;
      height: 50px;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
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

  <div id="loading" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-50">
    <div class="loader"></div>
  </div>

  <section id="content" class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8" style="display: none;">
    <header class="text-center">
      <h2 class="text-xl font-bold text-gray-900 sm:text-3xl">Watchlist</h2>
      <p class="mx-auto mt-4 max-w-md text-gray-500">
        Here are the trailers you added to your watchlist. Enjoy watching!
      </p>
    </header>
    <ul class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
      @forelse ($watchlistItems as $item)
      <li class="slide-up">
        <a href="{{ route('home.detail', $item->trailer->id) }}" class="group block overflow-hidden">
          <img src="{{ asset('upload/' . $item->trailer->poster) }}"
            alt="{{ $item->trailer->title }}"
            class="h-[350px] w-full object-cover transition duration-500 group-hover:scale-105 sm:h-[450px]" />

          <div class="relative bg-white pt-3">
            <h3 class="text-xs text-gray-700 group-hover:underline group-hover:underline-offset-4">
              {{ $item->trailer->title }}
            </h3>

            <p class="mt-2">
              <span class="sr-only"> Trailer Description </span>
              <span class="tracking-wider text-gray-900"> {{ Str::limit($item->trailer->deskripsi, 50) }} </span>
            </p>
          </div>
        </a>
      </li>
      @empty
      <li>
        <p class="text-center text-gray-500">Your watchlist is empty.</p>
      </li>
      @endforelse
    </ul>
  </section>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      document.getElementById("loading").style.display = "none";
      const content = document.getElementById("content");
      content.style.display = "block"; 
      const items = document.querySelectorAll(".slide-up");

      items.forEach((item, index) => {
        setTimeout(() => {
          item.classList.add("visible"); 
        }, index * 100); 
      });
    });
  </script>

</body>

</html>
