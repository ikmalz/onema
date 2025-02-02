<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trailer;

class MenuController extends Controller
{
    public function menu(Request $request)
    {
        $filter = $request->query('filter');

        $query = Trailer::withCount(['likes', 'dislikes', 'comments'])
            ->withAvg('ratings', 'rating');

        switch ($filter) {
            case 'rating_tertinggi':
                $query->orderBy('ratings_avg_rating', 'desc');
                break;

            case 'film_populer':
                $query->orderBy('likes_count', 'desc')
                    ->orderBy('comments_count', 'desc');
                break;

            case 'film_terbaru':
                $query->orderBy('tahun', 'desc');
                break;

            case 'serial_tv':
                $query->inRandomOrder();
                break;
        }

        $trailers = $query->get();

        return view('home.menu', compact('trailers', 'filter'));
    }
}
