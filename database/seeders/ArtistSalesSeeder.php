<?php

namespace Database\Seeders;

use App\Models\Artist;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArtistSalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::with('artistSales')->utenti()->get();
        $artistIds = Artist::count() - 1;
        foreach ($users as $user){
            $user->artistSales()->sync([rand(2, $artistIds), rand(2, $artistIds), rand(2, $artistIds), 1, 8, 9]);
        }
    }
}
