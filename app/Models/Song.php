<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['alb'];

    public function getAlbAttribute()
    {
        return $this->album;
    }

    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}
