<?php

namespace App\Console\Commands;

use App\Models\Game;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CreateWeeksGames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-weeks-games';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calls api and creates weeks games to store in db';

    /**
     * Execute the console command.
     */
    public function handle()
    {
      $this->info('Starting creating of weeks games...');

      try {
        $createdCount = 0;
        $currentWeek = config('app.current_week');
        $ur = 'https://site.api.espn.com/apis/site/v2/sports/football/nfl/scoreboard?limit=1000&dates=2025&seasontype=2&week='. $currentWeek;
        $response = file_get_contents($ur);
        if ($response === FALSE){
          $this->error('An error occurred fetching the new games.');
          throw new Exception();
        }
        else{
          $j = json_decode($response, true);
          foreach ($j['events'] as $game){
            $g = Game::create([
            'gameId'=>$game['id'],
            'startTime' =>  $game['date'],
            $game['competitions'][0]['competitors'][0]['homeAway'] => $game['competitions'][0]['competitors'][0]['team']['name'],
            $game['competitions'][0]['competitors'][1]['homeAway'] => $game['competitions'][0]['competitors'][1]['team']['name'],
            'week' => $currentWeek,
            'over' => '0',
            'spread' => '0',
            'homeFinal' => '0',
            'awayFinal' => '0',
            ]);
            $createdCount++;
          }
          $message = 'Successfully crated  ' . $createdCount . ' games.';
          $this->info($message);
          Log::info($message); // Log success to the application logs
        }


      }
      catch (\Exception $e){
        $this->error('An error occurred while creating games: ' . $e->getMessage());
        Log::error('CreateGames failed: ' . $e->getMessage());
      }
    }
}
