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

        $vitali = $artists->first();
        Album::insert([
            [
                'name' => 'album1',
                'artist_id' => $vitali->id
            ],
            [
                'name' => 'album2',
                'artist_id' => $vitali->id
            ],
            [
                'name' => 'album3',
                'artist_id' => $vitali->id
            ],
        ]);

        $artistsFiltered = $artists->filter(function ($artist){
            return $artist->id != 1;
        });

        foreach ($artistsFiltered as $artist){
            $numberOfAlbum = rand(1,3);
            Album::factory($numberOfAlbum)->create([
                'artist_id' => $artist->id
            ]);
        }
    }
}
