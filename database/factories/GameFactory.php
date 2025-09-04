<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Game;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [];
    }
    // call espn api to get list of weeks games and add to db
    // week specified in url
    public function createWeeksGames($week) {
      $ur = 'https://site.api.espn.com/apis/site/v2/sports/football/nfl/scoreboard?limit=1000&dates=2025&seasontype=2&week='. $week;
      $ch = curl_init($ur);
      curl_setopt($ch, CURLOPT_HEADER,0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $temp = curl_exec($ch);
      curl_close($ch);

      $j = json_decode($temp, true);
      foreach ($j['events'] as $game){
        $g = Game::create([
          'gameId'=>$game['id'],
          'startTime' =>  $game['date'],
          $game['competitions'][0]['competitors'][0]['homeAway'] => $game['competitions'][0]['competitors'][0]['team']['name'],
          $game['competitions'][0]['competitors'][1]['homeAway'] => $game['competitions'][0]['competitors'][1]['team']['name'],
          'week' => $week,
          'over' => '0',
          'spread' => '0',
          'homeFinal' => '0',
          'awayFinal' => '0',
        ]);
      }
    }


    public function updateSpreads($week) {
      foreach (Game::where('week', $week)->get() as $game){
        $gameId = $game->gameId;
        $ur = 'https://sports.core.api.espn.com/v2/sports/football/leagues/nfl/events/'.$gameId.'/competitions/'.$gameId.'/odds';
        $ch = curl_init($ur);
        curl_setopt($ch, CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $temp = curl_exec($ch);
        curl_close($ch);
        $j = json_decode($temp, true);
        $ou = $j['items'][0]['overUnder'];
        $spread = $j['items'][0]['homeTeamOdds']['current']['pointSpread']['american'];
        Game::where('gameid', $gameId)->update(['spread' => $spread, 'over'=>$ou]);
      }
    }
}
