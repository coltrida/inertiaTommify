<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlbumSalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::with('albumSales')->utenti()->get();
        $albumIds = Album::count() - 1;
        foreach ($users as $user){
            $user->albumSales()->sync([rand(1, $albumIds), rand(1, $albumIds), rand(1, $albumIds)]);
        }
    }
}
