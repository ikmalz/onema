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

        if ($filter === 'rating_tertinggi') {
            $trailers = $query->orderBy('ratings_avg_rating', 'desc')->get();
        } elseif ($filter === 'film_populer') {
            $trailers = $query->orderBy('likes_count', 'desc')
                ->orderBy('comments_count', 'desc')
                ->get();
        } elseif ($filter === 'film_terbaru') {
            $trailers = $query->orderBy('tahun', 'desc')->get();
        } elseif ($filter === 'serial_tv') {
            $trailers = $query->inRandomOrder()->get();
        } else {
            $trailers = $query->get();
        }

        return view('home.menu', compact('trailers', 'filter'));
    }
}
