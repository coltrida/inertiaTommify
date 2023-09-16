<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [FrontController::class, 'index'])->name('home');

//-------------------Admin------------------------------
Route::group(
    [
        'middleware' => ['auth','verifyIsAdmin'],
        'prefix' => 'admin'
    ],
    function() {
        Route::get('/home', [AdminController::class, 'home'])->name('admin.home');
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/artists', [AdminController::class, 'artists'])->name('admin.artists');
        Route::get('/albums', [AdminController::class, 'albums'])->name('admin.albums');
});

//-------------------Artist----------------------------
Route::group(
    [
        'middleware' => ['auth','verifyIsArtist'],
        'prefix' => 'artist'
    ],
    function() {
        Route::get('/home', [ArtistController::class, 'home'])->name('artist.home');
        Route::get('/myAlbums', [ArtistController::class, 'myAlbums'])->name('artist.myAlbums');
        Route::post('/myAlbums/create', [ArtistController::class, 'storeAlbum'])->name('artist.myAlbums.create');
        Route::get('/myAlbums/addSongs/{idAlbum}', [ArtistController::class, 'addSongs'])->name('artist.myAlbums.addSongs');
        Route::post('/myAlbums/addSongs', [ArtistController::class, 'storeSong'])->name('artist.myAlbums.storeSongs');
});

//-------------------User----------------------------
Route::group(
    [
        'middleware' => ['auth'],
        'prefix' => 'user'
    ],
    function() {
        Route::get('/myArtists', [UserController::class, 'myArtists'])->name('user.myArtists');
        Route::get('/allArtists', [UserController::class, 'allArtists'])->name('user.allArtists');
        Route::get('/allArtists/albums/{idArtist}', [UserController::class, 'albumsOfArtist'])->name('user.albumsOfArtist');
        Route::get('/allArtists/albums/songs/{idAlbum}', [UserController::class, 'songsOfAlbum'])->name('user.songsOfAlbum');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
