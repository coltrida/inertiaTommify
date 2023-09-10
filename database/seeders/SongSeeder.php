<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Song;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $albums = Album::all();
        foreach ($albums as $album){
            $numberOfSong = rand(1,4);
            Song::factory($numberOfSong)->create([
                'album_id' => $album->id
            ]);
        }
    }
}
