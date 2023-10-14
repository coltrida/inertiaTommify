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
        Route::get('/tags', [AdminController::class, 'tags'])->name('admin.tags');
        Route::post('/tags/insert', [AdminController::class, 'insertTag'])->name('admin.tags.insert');
        Route::delete('/tags/delete/{idTag}', [AdminController::class, 'deleteTag'])->name('admin.tags.delete');
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
        Route::get('/myClients', [ArtistController::class, 'myClients'])->name('artist.myClients');
        Route::get('/myAlbumSales', [ArtistController::class, 'myAlbumSales'])->name('artist.myAlbumSales');
});

//-------------------User----------------------------
Route::group(
    [
        'middleware' => ['auth'],
        'prefix' => 'user'
    ],
    function() {
        Route::get('/home', [UserController::class, 'home'])->name('user.home');
        Route::get('/settings', [UserController::class, 'settings'])->name('user.settings');
        Route::post('/saveImage', [UserController::class, 'saveImage'])->name('user.saveImage');
        Route::post('/settings', [UserController::class, 'postSettings'])->name('user.settings.post');
        Route::get('/myArtists', [UserController::class, 'myArtists'])->name('user.myArtists');
        Route::get('/allArtists', [UserController::class, 'allArtists'])->name('user.allArtists');
        Route::get('/allArtists/followers/{idArtist}', [UserController::class, 'followersArtist'])->name('user.allArtists.followers');
        Route::get('/allArtists/albums/followers/{idAlbum}', [UserController::class, 'followersAlbum'])->name('user.album.followers');
        Route::get('/allArtists/followers/{idArtist}/{idUser}', [UserController::class, 'followerUser'])->name('user.allArtists.follower.user');
        Route::get('/allArtists/albums/{idArtist}', [UserController::class, 'albumsOfArtist'])->name('user.albumsOfArtist');
        Route::get('/allArtists/albums/songs/{idAlbum}', [UserController::class, 'songsOfAlbum'])->name('user.songsOfAlbum');
        Route::post('/readNews', [UserController::class, 'readNews'])->name('user.readNews');
        Route::post('/playMyAlbum', [UserController::class, 'playMyAlbum'])->name('user.playMyAlbum');

        Route::post('/buyAlbum', [UserController::class, 'buyAlbum'])->name('user.buyAlbum');
        Route::get('/buyAlbum/success', [UserController::class, 'success'])->name('user.buyAlbum.success');
        Route::get('/buyAlbum/cancel', [UserController::class, 'cancel'])->name('user.buyAlbum.cancel');

        Route::get('/paypal', [UserController::class, 'paypal'])->name('user.paypal');
        Route::get('/paypal/success', [UserController::class, 'successPaypal'])->name('user.paypal.success');
        Route::get('/paypal/cancel', [UserController::class, 'cancelPaypal'])->name('user.paypal.cancel');
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
