<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [FrontController::class, 'index'])->name('home');

//-------------------Admin------------------------------
    Route::get('admin/home', [AdminController::class, 'home'])->name('admin.home');
    Route::get('admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('admin/artists', [AdminController::class, 'artists'])->name('admin.artists');
    Route::get('admin/albums', [AdminController::class, 'albums'])->name('admin.albums');


//-------------------Artist----------------------------
    Route::get('artist/home', [ArtistController::class, 'home'])->name('artist.home');
    Route::get('artist/myAlbums', [ArtistController::class, 'myAlbums'])->name('artist.myAlbums');
    Route::post('artist/myAlbums/create', [ArtistController::class, 'storeAlbum'])->name('artist.myAlbums.create');
    Route::get('artist/myAlbums/addSongs/{idAlbum}', [ArtistController::class, 'addSongs'])->name('artist.myAlbums.addSongs');
    Route::post('artist/myAlbums/addSongs', [ArtistController::class, 'storeSong'])->name('artist.myAlbums.storeSongs');



Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
