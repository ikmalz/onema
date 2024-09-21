<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Like;
use App\Models\Dislike;

class Trailer extends Model
{
    use HasFactory;

    protected $table = '_trailer';
    protected $fillable = [
        'title',
        'deskripsi',
        'poster',
        'vidio',
        'tahun',
        'populer'
    ];

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function dislikes()
    {
        return $this->hasMany(Dislike::class);
    }

    public function isLiked()
    {
        return $this->likes()->where('user_id', auth()->id())->exists();
    }


    public function isDisliked()
    {
        return $this->dislikes()->where('user_id', auth()->id())->exists();
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }


    public function averageRating()
    {
        $ratings = $this->ratings()->avg('rating');
        return $ratings ?: 0; // Jika tidak ada rating, kembalikan 0
    }


    public function userRating()
    {
        return $this->ratings()->where('user_id', auth()->id())->first();
    }

    public function totalLikes()
    {
        return $this->likes()->count();
    }

    public function totalDislikes()
    {
        return $this->dislikes()->count();
    }

    public function watchlists()
    {
        return $this->hasMany(Watchlist::class);
    }
}
