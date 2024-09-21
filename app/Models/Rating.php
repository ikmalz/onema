<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'trailer_id',
        'rating',
    ];

    public function trailer()
    {
        return $this->belongsTo(Trailer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
