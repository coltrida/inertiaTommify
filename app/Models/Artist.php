<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function albums()
    {
        return $this->hasMany(Album::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userSales()
    {
        return $this->belongsToMany(User::class, 'artist_sales', 'artist_id', 'user_id');
    }
}
