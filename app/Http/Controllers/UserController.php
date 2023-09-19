<?php

namespace App\Http\Controllers;

use App\Services\AlbumService;
use App\Services\ArtistService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    public function home(UserService $userService)
    {
        return Inertia::render('User/Home', [
            'myArtistsPaginate' => $userService->myArtistsPaginate(),
            'myAlbumsPaginate' => $userService->myAlbumsPaginate(),
            'filters' => \Illuminate\Support\Facades\Request::only(['searchArtist', 'searchAlbum'])
        ]);
    }

    public function myArtists(UserService $userService)
    {
        return Inertia::render('User/MyArtists', [
            'userConMyArtists' => $userService->userConMyArtists(),
            'filters' => \Illuminate\Support\Facades\Request::only('search')
        ]);
    }

    public function allArtists(ArtistService $artistService)
    {
        return Inertia::render('User/AllArtists', [
            'allArtists' => $artistService->allArtists(),
            'filters' => \Illuminate\Support\Facades\Request::only('search')
        ]);
    }

    public function albumsOfArtist($idArtist, ArtistService $artistService)
    {
        return Inertia::render('User/AlbumsOfArtist', [
            'artistConAlbums' => $artistService->artistConAlbums($idArtist)
        ]);
    }

    public function songsOfAlbum($idAlbum, AlbumService $albumService)
    {
        $albumConSongs = $albumService->albumConSongs($idAlbum);
        $albumComprato = $albumConSongs->userSales->contains('id', Auth::id());

        return Inertia::render('User/SongsOfAlbum', [
            'albumConSongs' => $albumConSongs,
            'albumComprato' => $albumComprato
        ]);
    }

    public function readNews(UserService $userService)
    {
        $userService->segnaLettoNotizie(Auth::id());
    }
}
