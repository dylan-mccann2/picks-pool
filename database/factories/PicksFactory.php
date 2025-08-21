<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Picks;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Picks>
 */
class PicksFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
          'week' => '1',
          'over' => 0.0,
          'overId' => '0',
          'under' => 0.0,
          'underId' => '0',
          'favoriteSpread' => 0.0,
          'favoriteId' => '',
          'favoriteTeam' => '',
          'underdogSpread' => 0.0,
          'underdogId' => '',
          'underdogTeam' => '',
        ];
    }

    public function createWeeksPicks($week){
      $users = User::all();
       foreach($users as $user){
        Picks::create([
          'week' => '1',
          'over' => 0.0,
          'overId' => '0',
          'under' => 0.0,
          'underId' => '0',
          'userId' => $user->id,
          'favoriteSpread' => 0.0,
          'favoriteId' => '',
          'favoriteTeam' => '',
          'underdogSpread' => 0.0,
          'underdogId' => '',
          'underdogTeam' => '',
        ]);
      }
    }
}
