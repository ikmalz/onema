<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Watchlist extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'trailer_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trailer()
    {
        return $this->belongsTo(Trailer::class, 'trailer_id');
    }
}
