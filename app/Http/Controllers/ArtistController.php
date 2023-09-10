<?php

namespace App\Http\Controllers;

use App\Services\ArtistService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ArtistController extends Controller
{
    public function myAlbums(ArtistService $artistService)
    {
        return Inertia::render('Artist/MyAlbums', [
            'myAlbums' => $artistService->myAlbums(Auth::id())
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
        $artistService->createAlbum($request);
    }
}
