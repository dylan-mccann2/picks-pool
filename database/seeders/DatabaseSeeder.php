<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Picks;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
          GamesTableSeeder::class,
          PicksTableSeeder::class,
          SettingsTableSeeder::class,
        ]);
    }
}
