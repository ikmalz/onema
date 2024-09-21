<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dislike extends Model
{
    protected $fillable = ['user_id', 'trailer_id'];

    public function trailer()
    {
        return $this->belongsTo(Trailer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
