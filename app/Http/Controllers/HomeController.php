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
use Illuminate\Support\Facades\App;
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

        $availableAccounts = User::where('id', '!=', Auth::id())->get();

        $watchlistItems = Watchlist::where('user_id', Auth::id())->with('trailer')->get();

        return view('home.homepage', compact('slider', 'recommendations', 'topOnema', 'availableAccounts', 'watchlistItems'));
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
            'gridVidio' => 'required|file|mimes:mp4,mov,avi,wmv|max:27480',
            'gridPoster' => 'required|mimes:jpeg,png,jpg,gif,svg,webp|max:2548',
            'gridThumbnail' => 'required|mimes:jpeg,png,jpg,gif,svg,webp|max:2548', // Validasi thumbnail
            'gridTahun' => 'required|integer',
            'gridOpsi' => 'required|string',
        ]);

        if ($request->hasFile('gridVidio') && $request->hasFile('gridPoster') && $request->hasFile('gridThumbnail')) {

            $videoName = $request->file('gridVidio')->getClientOriginalName();
            $posterName = $request->file('gridPoster')->getClientOriginalName();
            $thumbnailName = $request->file('gridThumbnail')->getClientOriginalName(); // Ambil nama file thumbnail

            $request->file('gridVidio')->move(public_path() . '/upload', $videoName);
            $request->file('gridPoster')->move(public_path() . '/upload', $posterName);
            $request->file('gridThumbnail')->move(public_path() . '/upload', $thumbnailName); // Simpan thumbnail

            DB::table('_trailer')->insert([
                'title' => $request->input('gridTitle'),
                'deskripsi' => $request->input('gridDeskripsi'),
                'vidio' => $videoName,
                'poster' => $posterName,
                'thumbnail' => $thumbnailName, // Simpan nama thumbnail ke database
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
            // Mendapatkan foto profil pengguna
            $profilePhoto = auth()->user()->profile_photo_path
                ? asset('storage/' . auth()->user()->profile_photo_path)
                : 'https://static.vecteezy.com/system/resources/thumbnails/005/129/844/small_2x/profile-user-icon-isolated-on-white-background-eps10-free-vector.jpg';

            return response()->json([
                'comment' => $comment->comment,
                'created_at' => now()->diffForHumans(),
                'user_name' => auth()->user()->username,
                'profile_photo' => $profilePhoto,
            ]);
        }

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan.');
    }


    public function toggleLikeComment(Request $request, $commentId)
    {
        $user = auth()->user();
        $comment = Comment::find($commentId);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        // Hapus dislike jika ada
        $existingDislike = DislikeComment::where('user_id', $user->id)->where('comment_id', $commentId)->first();
        if ($existingDislike) {
            $existingDislike->delete();
        }

        // Cek apakah sudah like, jika iya hapus like
        $existingLike = LikeComment::where('user_id', $user->id)->where('comment_id', $commentId)->first();
        if ($existingLike) {
            $existingLike->delete();
            return response()->json([
                'message' => 'Like removed',
                'likeCount' => $comment->likes()->count(),
                'dislikeCount' => $comment->dislikes()->count(),
                'status' => 'unliked'
            ], 200);
        }

        // Jika belum like, tambahkan like
        LikeComment::create([
            'user_id' => $user->id,
            'comment_id' => $commentId,
        ]);

        return response()->json([
            'message' => 'Comment liked',
            'likeCount' => $comment->likes()->count(),
            'dislikeCount' => $comment->dislikes()->count(),
            'status' => 'liked'
        ], 200);
    }

    public function toggleDislikeComment(Request $request, $commentId)
    {
        $user = auth()->user();
        $comment = Comment::find($commentId);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        // Hapus like jika ada
        $existingLike = LikeComment::where('user_id', $user->id)->where('comment_id', $commentId)->first();
        if ($existingLike) {
            $existingLike->delete();
        }

        // Cek apakah sudah dislike, jika iya hapus dislike
        $existingDislike = DislikeComment::where('user_id', $user->id)->where('comment_id', $commentId)->first();
        if ($existingDislike) {
            $existingDislike->delete();
            return response()->json([
                'message' => 'Dislike removed',
                'likeCount' => $comment->likes()->count(),
                'dislikeCount' => $comment->dislikes()->count(),
                'status' => 'undisliked'
            ], 200);
        }

        // Jika belum dislike, tambahkan dislike
        DislikeComment::create([
            'user_id' => $user->id,
            'comment_id' => $commentId,
        ]);

        return response()->json([
            'message' => 'Comment disliked',
            'likeCount' => $comment->likes()->count(),
            'dislikeCount' => $comment->dislikes()->count(),
            'status' => 'disliked'
        ], 200);
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
            'profile_photo_path' => auth()->user()->profile_photo_path ? asset('storage/' . auth()->user()->profile_photo_path) : 'https://static.vecteezy.com/system/resources/thumbnails/005/129/844/small_2x/profile-user-icon-isolated-on-white-background-eps10-free-vector.jpg',
            'reply_id' => $reply->id, // Mengirimkan ID balasan untuk penggunaan di frontend
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
    
        // Kembalikan rata-rata rating terbaru setelah rating berhasil
        return response()->json([
            'message' => 'Rating berhasil diberikan.',
            'averageRating' => $trailer->averageRating(),
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



    public function toggleWatchlist(Request $request, $trailerId)
    {
        $userId = auth()->id();

        // Cek apakah trailer sudah ada di watchlist user
        $existingWatchlist = Watchlist::where('user_id', $userId)
            ->where('trailer_id', $trailerId)
            ->first();

        if ($existingWatchlist) {
            // Jika sudah ada, hapus dari watchlist
            $existingWatchlist->delete();
            return response()->json(['status' => 'removed']);
        } else {
            // Jika belum ada, tambahkan ke watchlist
            Watchlist::create([
                'user_id' => $userId,
                'trailer_id' => $trailerId,
            ]);
            return response()->json(['status' => 'added']);
        }
    }

    public function watchlist()
    {
        $watchlistItems = Watchlist::where('user_id', auth()->id())
            ->whereHas('trailer')
            ->with('trailer')
            ->get() ?? [];

        return view('home.watchlists', compact('watchlistItems'));
    }

    public function changeLanguage(Request $request)
    {
        $lang = $request->input('lang');
        if (in_array($lang, ['en', 'id'])) {
            session(['language' => $lang]); // Mengubah session key menjadi 'language'
            App::setLocale($lang);
        }

        return redirect()->back(); // Kembali ke halaman sebelumnya
    }
}
