<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>


<section>
  <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
    <header class="text-center">
      <h2 class="text-xl font-bold text-gray-900 sm:text-3xl">Watchlist</h2>

      <p class="mx-auto mt-4 max-w-md text-gray-500">
        Here are the trailers you added to your watchlist. Enjoy watching!
      </p>
    </header>

    <ul class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
      @forelse ($watchlistItems as $item)
        <li>
          <a href="{{ route('home.detail', $item->id) }}" class="group block overflow-hidden">
            <img
              src="{{ asset('upload/' . $item->poster) }}"
              alt="{{ $item->title }}"
              class="h-[350px] w-full object-cover transition duration-500 group-hover:scale-105 sm:h-[450px]"
            />

            <div class="relative bg-white pt-3">
              <h3 class="text-xs text-gray-700 group-hover:underline group-hover:underline-offset-4">
                {{ $item->title }}
              </h3>

              <p class="mt-2">
                <span class="sr-only"> Trailer Description </span>
                <span class="tracking-wider text-gray-900"> {{ Str::limit($item->deskripsi, 50) }} </span>
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
  </div>
</section>



</body>
</html>