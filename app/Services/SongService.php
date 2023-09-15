<?php

namespace App\Services;

use App\Models\Song;

class SongService
{
    public function countOfSongs()
    {
        return Song::count();
    }
}
