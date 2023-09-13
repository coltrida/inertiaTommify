<?php

namespace App\Services;

use App\Models\Album;
use App\Models\Artist;
use Illuminate\Support\Facades\Request;

class ArtistService
{
    public function artistConMyAlbums($idArtist)
    {
        return Artist::with('albums')
            ->find($idArtist)
            ->albums()
            ->when(Request::input('search'), function ($query, $search){
                $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(3)
            ->withQueryString()
            ->through(fn($album) => [
                'id' => $album->id,
                'name' => $album->name,
                'artist' => $album->artist->user->name,
                'nrSongs' => $album->songs_count,
        ]);
    }

    public function createAlbum($request)
    {
        return Album::create($request->only(['name', 'artist_id']));
    }
}
