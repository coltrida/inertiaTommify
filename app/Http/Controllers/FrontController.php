<?php

namespace App\Http\Controllers;

use App\Services\AlbumService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;

class FrontController extends Controller
{
    public function index(AlbumService $albumService)
    {
        /*return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);*/

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY_TEST'));

      //  dd($stripe->balance->retrieve([]));
        $stripe->transfers->create([
            'amount' => 500,
            'currency' => 'usd',
            'destination' => 'acct_1O0AFjQxlLYvJpc2',
        ]);

        return Inertia::render('Home', [
            'lastCinqueAlbum' => $albumService->lastCinqueAlbum(),
            'bestCinqueAlbumSellers' => $albumService->bestCinqueAlbumSellers(),
        ]);
    }
}
