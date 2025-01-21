<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Watchlist;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function getUserHistory()
    {
        if (Auth::check()) {
            $historyItems = Watchlist::where('user_id', Auth::id())
                ->with('trailer')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json($historyItems);
        }
        return response()->json([]);
    }
}
