<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Film Recommendations</title>
    <link rel="icon" href="../asset/foto/logoonema.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>

<body>

    <!-- Back Icon -->
    <div class="container mx-auto px-4 py-4">
        <a href="javascript:history.back()" class="flex items-center text-red-500 hover:text-red-700">
            <i class="bx bx-arrow-back text-2xl mr-2"></i>
            <span class="text-lg font-semibold">Kembali</span>
        </a>
    </div>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-xl font-bold mb-4 border-l-4 border-red-700 pl-3 text-black">
            @if($filter == 'rating_tertinggi')
            Rating Tertinggi
            @elseif($filter == 'film_populer')
            Film Populer
            @elseif($filter == 'film_terbaru')
            Film Terbaru
            @elseif($filter == 'paling_dibicarakan')
            Paling Banyak Dibicarakan
            @else
            Semua Film
            @endif
        </h1>

        <p class="text-gray-400 mb-8">
            @if($filter == 'rating_tertinggi')
            Film dengan rating tertinggi sepanjang masa.
            @elseif($filter == 'film_populer')
            Genre terbaru dan klasik yang paling banyak dibicarakan.
            @elseif($filter == 'film_terbaru')
            Film terbaru yang wajib ditonton.
            @elseif($filter == 'paling_dibicarakan')
            Film yang paling banyak dibicarakan oleh penonton.
            @else
            Temukan berbagai pilihan film menarik untuk ditonton.
            @endif
        </p>

        <!-- Film List -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($trailers as $trailer)
            <div class="p-4 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300" style="background-color: #363434;">
                <a href="{{ route('home.detail', $trailer->id) }}" class="block">
                    <video poster="{{ asset('upload/' . $trailer->thumbnail) }}" class="w-full h-48 object-cover mb-4 bg-gray-800 rounded-lg overflow-hidden transform hover:scale-105 transition-transform duration-300">
                        <source src="{{ asset('upload/' . $trailer->vidio) }}" type="video/mp4">
                    </video>
                </a>
                <h3 class="text-lg font-bold text-red-500">{{ $trailer->title }}</h3>
            </div>
            @endforeach
        </div>
    </div>

</body>

</html>
