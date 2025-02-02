<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Watchlist;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function getUserHistory()
    {
        if (!Auth::check()) {
            return response()->json([]);
        }

        $historyItems = Watchlist::where('user_id', Auth::id())
            ->with('trailer')
            ->latest()
            ->get();

        return response()->json($historyItems);
    }
}
