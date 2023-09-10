<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [FrontController::class, 'index'])->name('home');

//-------------------Admin------------------------------
Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
Route::get('/artists', [AdminController::class, 'artists'])->name('admin.artists');

//-------------------Artist----------------------------
Route::get('/myAlbums', [ArtistController::class, 'myAlbums'])->name('artist.myAlbums');
Route::post('/myAlbums/create', [ArtistController::class, 'storeAlbum'])->name('artist.myAlbums.create');



Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
