<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function myArtists()
    {
        return Inertia::render('User/MyArtists');
    }

    public function allArtists()
    {
        return Inertia::render('User/AllArtists');
    }
}
