<?php

namespace App\Http\Controllers;

use App\Services\ArtistService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class ArtistController extends Controller
{
    public function home()
    {
        return Inertia::render('Artist/Home');
    }

    public function myAlbums(ArtistService $artistService)
    {
        return Inertia::render('Artist/MyAlbums', [
            'artistConMyAlbums' => $artistService->artistConMyAlbums(Auth::id()),
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
}
