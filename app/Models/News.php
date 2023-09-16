<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'news';
    protected $appends = ['utenti'];

    public function getUtentiAttribute()
    {
        return $this->users;
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'news_users', 'news_id', 'user_id')
            ->withPivot(['read']);
    }
}
