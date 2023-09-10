<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Artist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlbumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $artists = Artist::all();
        foreach ($artists as $artist){
            $numberOfAlbum = rand(1,3);
            Album::factory($numberOfAlbum)->create([
                'artist_id' => $artist->id
            ]);
        }
    }
}
