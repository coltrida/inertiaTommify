<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];
    protected $appends = ['created', 'mese'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getMeseAttribute()
    {
        return $this->created_at ? $this->created_at->month : null;
    }

    public function getCreatedAttribute()
    {
        return $this->created_at ? $this->created_at->format('d-m-Y') : null;
    }

    public function scopeUtenti($query)
    {
        return $query->where('role', 'user');
    }

    public function scopeArtisti($query)
    {
        return $query->where('role', 'artist');
    }

    public function isAdmin() {
        return $this->role === 'admin';
    }

    public function isArtist() {
        return $this->role === 'artist';
    }

    public function isUser() {
        return $this->role === 'user';
    }

    public function artist()
    {
        return $this->hasOne(Artist::class);
    }

    public function albumSales()
    {
        return $this->belongsToMany(Album::class, 'album_sales', 'user_id', 'album_id');
    }

    public function artistSales()
    {
        return $this->belongsToMany(Artist::class, 'artist_sales', 'user_id', 'artist_id');
    }

    public function news()
    {
        return $this->belongsToMany(News::class, 'news_users', 'user_id', 'news_id')
            ->withPivot(['read']);
    }

    public function newsNotRead()
    {
        return $this->belongsToMany(News::class, 'news_users', 'user_id', 'news_id')
            ->withPivot(['read'])->where('read', 0);
    }

}
