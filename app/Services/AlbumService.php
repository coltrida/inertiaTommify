<?php

namespace App\Services;

use App\Models\Album;
use App\Models\Song;
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

    public function lastCinqueAlbum()
    {
        /*dd(Album::latest()->limit(5)->get()->map(fn($album) => [
            'id' => $album->id,
            'name' => $album->name,
        ]));*/
        return Album::latest()->limit(5)->get()->map(fn($album) => [
            'id' => $album->id,
            'name' => $album->name,
        ]);
    }

    public function bestCinqueAlbumSellers()
    {
        /*dd(Album::withCount('userSales')->with('userSales')->limit(5)->get()->sortByDesc(function ($album){
            return $album->userSales()->count();
        })->map(fn($album) => [
            'id' => $album->id,
            'name' => $album->name,
        ]));*/
        return Album::withCount('userSales')->with('userSales')->limit(5)->get()->sortByDesc(function ($album){
            return $album->userSales()->count();
        })->map(fn($album) => [
            'id' => $album->id,
            'name' => $album->name,
        ]);
    }

    public function albumConSongs($idAlbum)
    {
        /*dd(Album::select('id','name')->with(['songs' => function($s){
            $s->latest()->select('id', 'album_id', 'name');
        }])->find($idAlbum));*/
        return Album::select('id','name')->with(['songs' => function($s){
            $s->latest()->select('id', 'album_id', 'name');
        }])->find($idAlbum);
    }

    public function addSong($request)
    {
        return Song::create($request->only(['name', 'album_id']));
    }

    public function countOfAlbums()
    {
        return Album::count();
    }
}
