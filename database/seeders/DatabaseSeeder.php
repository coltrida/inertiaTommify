<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(UserSeeder::class);
        $this->call(ArtistSeeder::class);
        $this->call(AlbumSeeder::class);
        $this->call(SongSeeder::class);
    //    $this->call(AlbumSalesSeeder::class);
    //    $this->call(ArtistSalesSeeder::class);

        Storage::disk('public')->deleteDirectory('covers/');
        Storage::disk('public')->deleteDirectory('songs/');

        Storage::disk('public')->makeDirectory('covers/');
        Storage::disk('public')->makeDirectory('songs/');

        Storage::copy('1.mp3', 'public/songs/1.mp3');
        Storage::copy('2.mp3', 'public/songs/2.mp3');
        Storage::copy('3.mp3', 'public/songs/3.mp3');
        Storage::copy('4.mp3', 'public/songs/4.mp3');
        Storage::copy('5.mp3', 'public/songs/5.mp3');
        Storage::copy('6.mp3', 'public/songs/6.mp3');
        Storage::copy('7.mp3', 'public/songs/7.mp3');
        Storage::copy('8.mp3', 'public/songs/8.mp3');
        Storage::copy('9.mp3', 'public/songs/9.mp3');
        Storage::copy('10.mp3', 'public/songs/10.mp3');
        Storage::copy('11.mp3', 'public/songs/11.mp3');
        Storage::copy('12.mp3', 'public/songs/12.mp3');
        Storage::copy('13.mp3', 'public/songs/13.mp3');
        Storage::copy('14.mp3', 'public/songs/14.mp3');
        Storage::copy('15.mp3', 'public/songs/15.mp3');
        Storage::copy('16.mp3', 'public/songs/16.mp3');
        Storage::copy('17.mp3', 'public/songs/17.mp3');
        Storage::copy('18.mp3', 'public/songs/18.mp3');
        Storage::copy('19.mp3', 'public/songs/19.mp3');
        Storage::copy('20.mp3', 'public/songs/20.mp3');

        Storage::copy('1.jpg', 'public/covers/1.jpg');
        Storage::copy('2.jpg', 'public/covers/2.jpg');
        Storage::copy('3.jpg', 'public/covers/3.jpg');
        Storage::copy('4.jpg', 'public/covers/4.jpg');
        Storage::copy('5.jpg', 'public/covers/5.jpg');
        Storage::copy('6.jpg', 'public/covers/6.jpg');
        Storage::copy('7.jpg', 'public/covers/7.jpg');
        Storage::copy('8.jpg', 'public/covers/8.jpg');
        Storage::copy('9.jpg', 'public/covers/9.jpg');
        Storage::copy('10.jpg', 'public/covers/10.jpg');
    }
}
