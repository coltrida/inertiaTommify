<?php

namespace App\Http\Controllers;

use App\Services\AlbumService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function users(UserService $userService)
    {
        return Inertia::render('Admin/Users', [
            'users' => $userService->listOfUsers(),
            'filters' => \Illuminate\Support\Facades\Request::only('search')
        ]);
    }

    public function artists(UserService $userService)
    {
        return Inertia::render('Admin/Artists', [
            'artists' => $userService->listOfArtists(),
            'filters' => \Illuminate\Support\Facades\Request::only('search')
        ]);
    }

    public function albums(AlbumService $albumService)
    {
        return Inertia::render('Admin/Albums', [
            'albums' => $albumService->listOfAlbums(),
            'filters' => \Illuminate\Support\Facades\Request::only('search')
        ]);
    }
}
