<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Request;

class UserService
{
    public function listOfUsers()
    {
        return User::utenti()
            ->when(Request::input('search'), function ($query, $search){
                $query->where('name', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->withQueryString()
            ->through(fn($user) => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created' => $user->created,
        ]);
    }

    public function listOfArtists()
    {
        return User::artisti()
            ->when(Request::input('search'), function ($query, $search){
                $query->where('name', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->withQueryString()
            ->through(fn($user) => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created' => $user->created,
        ]);
    }
}
