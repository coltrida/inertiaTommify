<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Artist
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $stripe_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Album> $albums
 * @property-read int|null $albums_count
 * @property-read \App\Models\User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $userSales
 * @property-read int|null $user_sales_count
 * @method static \Illuminate\Database\Eloquent\Builder|Artist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Artist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Artist query()
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereUserId($value)
 * @mixin \Eloquent
 */
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

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

    public function userSales()
    {
        return $this->belongsToMany(User::class, 'artist_sales', 'artist_id', 'user_id');
    }
}
