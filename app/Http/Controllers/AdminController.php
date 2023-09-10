<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function users(UserService $userService)
    {
        return Inertia::render('Admin/Users', [
            'users' => $userService->listOfUsers()
        ]);
    }
}
