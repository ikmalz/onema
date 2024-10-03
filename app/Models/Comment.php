<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'trailer_id', 'comment'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trailer()
    {
        return $this->belongsTo(Trailer::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function likes()
    {
        return $this->hasMany(LikeComment::class, 'comment_id');
    }

    public function dislikes()
    {
        return $this->hasMany(DislikeComment::class, 'comment_id');
    }
}
