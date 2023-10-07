<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $role
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Album> $albumSales
 * @property-read int|null $album_sales_count
 * @property-read \App\Models\Artist|null $artist
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Artist> $artistSales
 * @property-read int|null $artist_sales_count
 * @property-read mixed $created
 * @property-read mixed $mese
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\News> $news
 * @property-read int|null $news_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\News> $newsNotRead
 * @property-read int|null $news_not_read_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|User artisti()
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User utenti()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];
    protected $appends = ['created', 'mese', 'avatar'];

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

    public function getAvatarAttribute()
    {
        return \Storage::disk('public')->fileExists('/users/'.$this->id.'.jpg') ?
            '/storage/users/'.$this->id.'.jpg' : '/storage/users/user.jpg';
    }

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
        return $this->belongsToMany(Album::class, 'album_sales', 'user_id', 'album_id')
            ->withPivot('updated_at');
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

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tags_users', 'user_id', 'tag_id');
    }
}
