<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
