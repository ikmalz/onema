<?php

namespace App\Http\Controllers;

use App\Models\Watchlist;
use Illuminate\Http\Request;

class WatchlistController extends Controller
{
    public function toggleWatchlist(Request $request, $trailerId)
    {
        $userId = auth()->id();

        $existingWatchlist = Watchlist::where('user_id', $userId)
            ->where('trailer_id', $trailerId)
            ->first();

        if ($existingWatchlist) {
            $existingWatchlist->delete();
            return response()->json(['status' => 'removed']);
        }

        Watchlist::create([
            'user_id' => $userId,
            'trailer_id' => $trailerId,
        ]);

        return response()->json(['status' => 'added']);
    }

    public function watchlist()
    {
        $watchlistItems = Watchlist::where('user_id', auth()->id())
            ->whereHas('trailer')
            ->with('trailer')
            ->get();

        return view('home.watchlists', compact('watchlistItems'));
    }
}
