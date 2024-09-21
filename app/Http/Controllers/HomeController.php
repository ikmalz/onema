<?php

namespace App\Http\Controllers;

use App\Models\Trailer;
use App\Models\Comment; // Tambahkan ini
use App\Models\CommentLike; // Tambahkan ini jika Anda juga menggunakan model untuk likes
use App\Models\Reply;
use App\Models\Watchlist;
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
    
        return view('home.homepage', compact('slider', 'recommendations', 'topOnema'));
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
            // Mengambil nama asli file video dan poster
            $videoName = $request->file('gridVidio')->getClientOriginalName();
            $posterName = $request->file('gridPoster')->getClientOriginalName();

            // Memindahkan file video dan poster ke direktori 'upload'
            $request->file('gridVidio')->move(public_path() . '/upload', $videoName);
            $request->file('gridPoster')->move(public_path() . '/upload', $posterName);

            // Menyimpan data ke dalam database
            DB::table('_trailer')->insert([
                'title' => $request->input('gridTitle'),
                'deskripsi' => $request->input('gridDeskripsi'),
                'vidio' => $videoName, // Menyimpan nama file video ke dalam kolom 'vidio'
                'poster' => $posterName, // Menyimpan nama file poster ke dalam kolom 'poster'
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

        // Cek apakah user sudah like video
        $like = $video->likes()->where('user_id', $user->id)->first();

        if ($like) {
            // Jika sudah like, maka unlike
            $like->delete();
            return response()->json(['status' => 'unliked']);
        } else {
            // Jika belum like, tambahkan like
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

        // Cek apakah user sudah dislike video
        $dislike = $video->dislikes()->where('user_id', $user->id)->first();

        if ($dislike) {
            // Jika sudah dislike, maka hapus dislike
            $dislike->delete();
            return response()->json(['status' => 'undisliked']);
        } else {
            // Jika belum dislike, tambahkan dislike
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

        $comments = Comment::where('trailer_id', $id)->with('replies', 'user')->get();

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
                'user_name' => auth()->user()->username // Pastikan username dikirim
            ]);
        }

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan.');
    }

    public function likeComment(Request $request, $comment_id)
    {
        $comment = Comment::findOrFail($comment_id);

        $comment->likes += 1;
        $comment->save();

        return response()->json(['likes' => $comment->likes]);
    }

    public function dislikeComment(Request $request, $comment_id)
    {
        $comment = Comment::findOrFail($comment_id);

        $comment->dislikes += 1;
        $comment->save();

        return response()->json(['dislikes' => $comment->dislikes]);
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
        $watchlistItems = $user->watchlist()->with('trailer')->get();
    
        return view('home.watchlist', compact('watchlistItems'));
    }
    

    public function toggleWatchlist(Request $request, $trailerId)
    {
        $user = Auth::user();

        // Cek apakah trailer sudah ada di watchlist
        $watchlist = Watchlist::where('user_id', $user->id)
            ->where('trailer_id', $trailerId)
            ->first();

        if ($watchlist) {
            // Jika sudah ada, hapus dari watchlist
            $watchlist->delete();
            return response()->json(['status' => 'removed']);
        } else {
            // Jika belum ada, tambahkan ke watchlist
            Watchlist::create([
                'user_id' => $user->id,
                'trailer_id' => $trailerId,
            ]);
            return response()->json(['status' => 'added']);
        }
    }
}
