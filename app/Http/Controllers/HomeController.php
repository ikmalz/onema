<?php

namespace App\Http\Controllers;

use App\Models\Trailer;
use App\Models\Watchlist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $slider = DB::table('_trailer')->inRandomOrder()->get();
        $recommendations = DB::table('_trailer')->inRandomOrder()->limit(3)->get();
        
        $topOnema = Trailer::withCount(['likes', 'dislikes'])
            ->with('ratings')
            ->orderBy('populer', 'desc')
            ->get();

        $availableAccounts = User::where('id', '!=', Auth::id())->get();

        $watchlistItems = Watchlist::where('user_id', Auth::id())
            ->with('trailer')
            ->get();

        return view('home.homepage', compact(
            'slider', 'recommendations', 'topOnema', 
            'availableAccounts', 'watchlistItems'
        ));
    }

    public function ikmal()
    {
        return view('home.detail');
    }
}
