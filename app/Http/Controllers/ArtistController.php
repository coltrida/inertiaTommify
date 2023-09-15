<?php

namespace App\Http\Controllers;

use App\Services\AlbumService;
use App\Services\ArtistService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class ArtistController extends Controller
{
    public function home(ArtistService $artistService)
    {
        return Inertia::render('Artist/Home', [
            'infoArtistConAlbumEvendite' => $artistService->infoArtistConAlbumEvendite(Auth::user()->artist->id),
            'BestAlbumSales' => $artistService->BestAlbumSales(Auth::user()->artist->id),
        ]);
    }

    public function myAlbums(ArtistService $artistService)
    {
        return Inertia::render('Artist/MyAlbums', [
            'artistConMyAlbums' => $artistService->artistConMyAlbums(Auth::user()->artist->id),
            'filters' => \Illuminate\Support\Facades\Request::only('search')
        ]);
    }

    public function storeAlbum(Request $request, ArtistService $artistService)
    {
        $request->validate([
            'name' => 'required'
        ],
        [
            'name.required' => 'Nome Album obbligatorio!',
        ]);

        $request->merge(['artist_id' => Auth::id()]);
        $album = $artistService->createAlbum($request);
        if ($request->hasFile('cover')){
            $file = $request->file('cover')[0];
            $filename = $album->id . '.jpg';
            $file->storeAs('public/covers/', $filename);
        }
    }

    public function addSongs($idAlbum, AlbumService $albumService)
    {
        return Inertia::render('Artist/AddSongs', [
            'albumConSongs' => $albumService->albumConSongs($idAlbum)
        ]);
    }

    public function storeSong(Request $request, AlbumService $albumService)
    {
        $request->validate([
            'name' => 'required'
        ],
            [
                'name.required' => 'Nome Song obbligatorio!',
            ]);

        $song = $albumService->addSong($request);
        if ($request->hasFile('song')){
            $file = $request->file('song')[0];
            $filename = $song->id . '.mp3';
            $file->storeAs('public/songs/', $filename);
        }
    }
}
