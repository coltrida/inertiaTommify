<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Index', [
        'users' => \App\Models\User::latest()->get()
    ]);
})->name('home');

Route::get('/posts/{user:id}', function (\App\Models\User $user) {
    return Inertia::render('Show', [
        'user' => $user
    ]);
})->name('article.show');
