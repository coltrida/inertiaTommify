<?php

namespace App\Services;

use App\Models\Album;
use Illuminate\Support\Facades\Request;

class AlbumService
{
    public function listOfAlbums()
    {
        return Album::
            with('artist')
            ->withCount('songs')
            ->when(Request::input('search'), function ($query, $search){
                $query->where('name', 'like', "%{$search}%");
            })
            ->paginate(5)
            ->withQueryString()
            ->through(fn($album) => [
                'id' => $album->id,
                'name' => $album->name,
                'artist' => $album->artist->user->name,
                'nrSongs' => $album->songs_count,
            ]);

    }
}
