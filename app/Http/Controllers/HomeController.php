<?php

namespace App\Http\Controllers;

use App\Models\Trailer;
use App\Models\Comment; // Tambahkan ini
use App\Models\Dislike;
use App\Models\LikeComment; // Tambahkan ini jika Anda juga menggunakan model untuk likes
use App\Models\DislikeComment; // Tambahkan ini jika Anda juga menggunakan model untuk likes
use App\Models\Reply;
use App\Models\Watchlist;
use App\Models\User;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        $slider = DB::table('_trailer')->inRandomOrder()->get();
        $recommendations = DB::table('_trailer')->inRandomOrder()->limit(3)->get();
        $topOnema = Trailer::withCount(['likes', 'dislikes'])
            ->orderBy('populer', 'desc')
            ->get();

        $watchlistItems = Watchlist::where('user_id', Auth::id())
            ->with('trailer')
            ->get();

        $availableAccounts = User::where('id', '!=', Auth::id())->get();

        return view('home.homepage', compact('slider', 'recommendations', 'topOnema', 'watchlistItems', 'availableAccounts'));
    }


    public function ikmal()
    {
        return view('home.detail');
    }

    public function create(Request $request)
    {
        $request->validate([
            'gridTitle' => 'required|string|max:255',
            'gridDeskripsi' => 'required|string',
            'gridVidio' => 'required|file|mimes:mp4,mov,avi,wmv|max:20480',
            'gridPoster' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gridTahun' => 'required|integer',
            'gridOpsi' => 'required|string',
        ]);

        if ($request->hasFile('gridVidio') && $request->hasFile('gridPoster')) {

            $videoName = $request->file('gridVidio')->getClientOriginalName();
            $posterName = $request->file('gridPoster')->getClientOriginalName();

            $request->file('gridVidio')->move(public_path() . '/upload', $videoName);
            $request->file('gridPoster')->move(public_path() . '/upload', $posterName);

            DB::table('_trailer')->insert([
                'title' => $request->input('gridTitle'),
                'deskripsi' => $request->input('gridDeskripsi'),
                'vidio' => $videoName,
                'poster' => $posterName,
                'tahun' => $request->input('gridTahun'),
                'populer' => $request->input('gridOpsi'),
            ]);
        }


        return redirect()->route('home')->with('success', 'Film berhasil ditambahkan!');
    }

    public function likeVideo(Request $request, $id)
    {
        $video = Trailer::findOrFail($id);
        $user = Auth::user();

        $like = $video->likes()->where('user_id', $user->id)->first();

        if ($like) {
            $like->delete();
            return response()->json(['status' => 'unliked']);
        } else {
            $video->likes()->create([
                'user_id' => $user->id,
            ]);
            return response()->json(['status' => 'liked']);
        }
    }

    public function dislikeVideo(Request $request, $id)
    {
        $video = Trailer::findOrFail($id);
        $user = Auth::user();

        $dislike = $video->dislikes()->where('user_id', $user->id)->first();

        if ($dislike) {
            $dislike->delete();
            return response()->json(['status' => 'undisliked']);
        } else {
            $video->dislikes()->create([
                'user_id' => $user->id,
            ]);
            return response()->json(['status' => 'disliked']);
        }
    }




    //komentar
    public function show($id)
    {
        $detail = Trailer::find($id);

        if (!$detail) {
            return redirect()->back()->with('error', 'Data not found');
        }

        $comments = Comment::where('trailer_id', $id)
            ->with(['replies', 'user', 'likes', 'dislikes'])
            ->get();

        $userHasRated = Rating::where('user_id', auth()->id())
            ->where('trailer_id', $id)
            ->exists();

        return view('home.detail', compact('detail', 'comments', 'userHasRated'));
    }



    public function storeComment(Request $request, $trailer_id)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'trailer_id' => $trailer_id,
            'comment' => $request->comment,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'comment' => $comment->comment,
                'created_at' => now()->diffForHumans(),
                'user_name' => auth()->user()->username
            ]);
        }

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan.');
    }

    public function likeComment($id)
    {
        $comment = Comment::findOrFail($id);
        $user_id = Auth::id();

        $existing_like = LikeComment::where('comment_id', $id)->where('user_id', $user_id)->first();
        $existing_dislike = DislikeComment::where('comment_id', $id)->where('user_id', $user_id)->first();

        if ($existing_like) {
            $existing_like->delete();
            $like_count = LikeComment::where('comment_id', $id)->count();
            return response()->json(['status' => 'like removed', 'like_count' => $like_count]);
        } else {
            LikeComment::create([
                'user_id' => $user_id,
                'comment_id' => $id,
            ]);

            if ($existing_dislike) {
                $existing_dislike->delete();
            }

            $like_count = LikeComment::where('comment_id', $id)->count();
            return response()->json(['status' => 'liked', 'like_count' => $like_count]);
        }
    }

    public function dislikeComment($id)
    {
        $comment = Comment::findOrFail($id);
        $user_id = Auth::id();

        $existing_dislike = DislikeComment::where('comment_id', $id)->where('user_id', $user_id)->first();
        $existing_like = LikeComment::where('comment_id', $id)->where('user_id', $user_id)->first();

        if ($existing_dislike) {
            $existing_dislike->delete();
            $dislike_count = DislikeComment::where('comment_id', $id)->count();
            return response()->json(['status' => 'dislike removed', 'dislike_count' => $dislike_count]);
        } else {
            DislikeComment::create([
                'user_id' => $user_id,
                'comment_id' => $id,
            ]);

            if ($existing_like) {
                $existing_like->delete();
            }

            $dislike_count = DislikeComment::where('comment_id', $id)->count();
            return response()->json(['status' => 'disliked', 'dislike_count' => $dislike_count]);
        }
    }


    public function storeReply(Request $request, Comment $comment)
    {
        $request->validate([
            'reply' => 'required|string|max:500',
        ]);

        $reply = Reply::create([
            'comment_id' => $comment->id,
            'user_id' => auth()->id(),
            'reply' => $request->reply,
        ]);

        return response()->json([
            'user_name' => auth()->user()->username,
            'reply' => $reply->reply,
            'created_at' => $reply->created_at->diffForHumans(),
        ]);
    }

    public function rateVideo(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $trailer = Trailer::findOrFail($id);
        $user = Auth::user();

        $existingRating = Rating::where('user_id', $user->id)
            ->where('trailer_id', $trailer->id)
            ->first();

        if ($existingRating) {
            return response()->json([
                'message' => 'Anda sudah memberikan rating untuk video ini.',
                'averageRating' => $trailer->averageRating(),
            ]);
        }

        Rating::create([
            'user_id' => $user->id,
            'trailer_id' => $trailer->id,
            'rating' => $request->rating,
        ]);

        $averageRating = $trailer->averageRating();

        return response()->json([
            'message' => 'Terima kasih atas rating Anda!',
            'averageRating' => $averageRating,
        ]);
    }

    public function deleteRating(Request $request, $id)
    {
        $trailer = Trailer::findOrFail($id);
        $user = Auth::user();

        $existingRating = Rating::where('user_id', $user->id)
            ->where('trailer_id', $trailer->id)
            ->first();

        if ($existingRating) {
            $existingRating->delete();

            return response()->json([
                'success' => true,
                'message' => 'Rating berhasil dihapus!',
                'userHasRated' => false,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Rating tidak ditemukan!',
        ]);
    }

    public function watchlist()
    {
        $user = Auth::user();

        $watchlistItems = Watchlist::where('user_id', $user->id)
            ->with('trailer')
            ->get();

        return view('home.watchlists', compact('watchlistItems'));
    }


    public function toggleWatchlist($id)
    {
        $user = Auth::user();
        $watchlistItem = Watchlist::where('user_id', $user->id)->where('trailer_id', $id)->first();

        if ($watchlistItem) {
            $watchlistItem->delete(); // Hapus dari watchlist jika sudah ada
            return response()->json(['status' => 'removed']);
        } else {
            Watchlist::create([
                'user_id' => $user->id,
                'trailer_id' => $id
            ]); // Tambahkan ke watchlist jika belum ada
            return response()->json(['status' => 'added']);
        }
    }




    // WatchlistController.php
    public function getWatchlistData()
    {
        $watchlistItems = Watchlist::with('trailer')->where('user_id', auth()->id())->get();

        return response()->json($watchlistItems);
    }
}
