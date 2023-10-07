<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::utenti()->get();
        $tagsId = Tag::all()->pluck('id')->toArray();
        $randomId = array_splice($tagsId, 0, array_rand($tagsId));
        foreach ($users as $user){
            $user->tags()->attach($randomId);
        }
    }
}
