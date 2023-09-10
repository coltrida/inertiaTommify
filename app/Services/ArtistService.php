<?php

namespace App\Services;

use App\Models\Album;
use App\Models\Artist;

class ArtistService
{
    public function myAlbums($idArtist)
    {
        return Artist::with(['albums' => function($a){
            $a->latest();
        }])->find($idArtist)->albums;
    }

    public function createAlbum($request)
    {
        Album::create($request->all());
    }
}
