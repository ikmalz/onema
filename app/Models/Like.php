<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = ['user_id', 'trailer_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trailer()
    {
        return $this->belongsTo(Trailer::class);
    }
}
