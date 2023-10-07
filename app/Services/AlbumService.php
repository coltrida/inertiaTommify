<?php

namespace App\Services;

use App\Models\Album;
use App\Models\Song;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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
        return Album::select('id','name')->with(['userSales','songs' => function($s){
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

    public function aggiornaAscoltaAlbum($request)
    {
        User::find(Auth::id())->albumSales()->updateExistingPivot($request->albumId, ['updated_at' => Carbon::now()]);
    }

    public function buyAlbum($request)
    {
        $user = User::find(Auth::id());
        $user->albumSales()->attach($request->album['id']);
        $idArtist = $request->album['artist_id'];

        if (!$user->artistSales->contains('id', $idArtist)){
            $user->artistSales()->attach($idArtist);
        }
    }

    public function followersOfAlbum($idAlbum)
    {
        return Album::with('userSales')->find($idAlbum);
    }
}
