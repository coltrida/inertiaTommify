<?php

namespace App\Http\Controllers;

use App\Events\createAlbumEvent;
use App\Models\Artist;
use App\Models\News;
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
        $infoArtistConAlbumEvendite = $artistService->infoArtistConAlbumEvendite(Auth::user()->artist->id);
        $totAlbumVendite = $infoArtistConAlbumEvendite->albums->sum('user_sales_count');
        return Inertia::render('Artist/Home', [
            'infoArtistConAlbumEvendite' => $infoArtistConAlbumEvendite,
            'totAlbumVendite' => $totAlbumVendite,
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

        $request->merge(['artist_id' => Auth::user()->artist->id]);
        $album = $artistService->createAlbum($request);
        if ($request->hasFile('cover')){
            $file = $request->file('cover')[0];
            $filename = $album->id . '.jpg';
            $file->storeAs('public/covers/', $filename);
        }

        $news = News::create([
            'message' => Auth::user()->name." has created new Album"
        ]);

        $usersSalesOfThisArtist = Artist::with('userSales')->find(Auth::user()->artist->id)->userSales;

        $news->users()->attach($usersSalesOfThisArtist);

        broadcast(new createAlbumEvent($news))->toOthers();
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

    public function myClients(ArtistService $artistService)
    {
        return Inertia::render('Artist/MyClients', [
            'myClients' => $artistService->listOfClients(Auth::user()->artist->id)
        ]);
    }

    public function myAlbumSales(ArtistService $artistService)
    {
        return Inertia::render('Artist/MySales', [
            'myAlbumSales' => $artistService->listOfMyAlbumSales(Auth::user()->artist->id)
        ]);
    }
}
