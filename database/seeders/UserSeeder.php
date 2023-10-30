<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.it',
            'role' => 'admin',
            'country' => null,
            'city' => null,
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('123456'),
        ]);

/*        User::create([
            'name' => 'cacao',
            'email' => 'cacao@cacao.it',
            'role' => 'user',
            'country' => 'Italy',
            'city' => 'Florence',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'name' => 'vitali',
            'email' => 'vitali@vitali.it',
            'role' => 'artist',
            'country' => null,
            'city' => null,
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('123456'),
        ]);

        User::factory(50)->create();*/
    }
}
