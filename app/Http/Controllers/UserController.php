<?php

namespace App\Http\Controllers;

use App\Services\ArtistService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
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
}
