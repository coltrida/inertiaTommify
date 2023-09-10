<?php

namespace Database\Seeders;

use App\Models\Artist;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ArtistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $artists = User::where('role', 'artist')->get();
        foreach ($artists as $artist){
            Artist::create([
                'user_id' => $artist->id
            ]);
        }
    }
}
