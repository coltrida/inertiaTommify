<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function listOfUsers()
    {
        return User::utenti()->paginate(3)->through(fn($user) => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'created' => $user->created,
        ]);
        /*return User::utenti()->paginate(3)->map(fn($user) => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'created' => $user->created,
        ]);*/
    }
}
