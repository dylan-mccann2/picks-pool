<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::updateOrCreate(
            ['key' => 'current_week'],
            ['value' => '2'],
        );
        Setting::updateOrCreate(
            ['key' => 'current_leader'],
            ['value' => '0'],
        );
    }
}
