<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Album
 *
 * @property int $id
 * @property int $artist_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Artist|null $artist
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Song> $songs
 * @property-read int|null $songs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $userSales
 * @property-read int|null $user_sales_count
 * @method static \Database\Factories\AlbumFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Album newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Album newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Album query()
 * @method static \Illuminate\Database\Eloquent\Builder|Album whereArtistId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Album whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Album whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Album whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Album whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Album extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function songs()
    {
        return $this->hasMany(Song::class);
    }

    public function userSales()
    {
        return $this->belongsToMany(User::class, 'album_sales', 'album_id', 'user_id');
    }
}
