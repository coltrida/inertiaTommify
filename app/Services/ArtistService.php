<?php

namespace App\Services;

use App\Models\Album;
use App\Models\Artist;
use Illuminate\Support\Facades\Request;

class ArtistService
{
    public function artistConMyAlbums($idArtist)
    {
        /*dd(Artist::with(['albums' => function($a){
            $a->withCount('songs');
        }])
            ->find($idArtist)
            ->albums()->withCount('songs')
            ->paginate(3)

        );*/

        /*dd(Artist::with(['albums' => function($a){
            $a->withCount('songs');
        }])
            ->find($idArtist)
            ->albums()->withCount('songs')
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
            ]));*/

        return Artist::with(['albums' => function($a){
            $a->withCount('songs');
        }])
            ->find($idArtist)
            ->albums()->withCount('songs')
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

    public function infoArtistConAlbumEvendite($idArtist)
    {
        /*dd(Artist::select('id')
            ->withCount('albums')
            ->withCount('userSales')
            ->find($idArtist));*/

        return Artist::select('id')
            ->withCount('albums')
            ->withCount('userSales')
            ->find($idArtist);
    }

    public function BestAlbumSales($idArtist)
    {
        /*dd(Artist::with('albums')
            ->find($idArtist)
            ->albums()->select('id', 'name')->withCount('userSales')
            ->get()->sortByDesc(function ($album){
                return $album->userSales()->count();
            })->first()
        );*/

        return Artist::with('albums')
            ->find($idArtist)
            ->albums()->select('id', 'name')->withCount('userSales')
            ->get()->sortByDesc(function ($album){
                return $album->userSales()->count();
            })->first();
    }
}
