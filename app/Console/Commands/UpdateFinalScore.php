<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Game;
use Illuminate\Support\Facades\Log;

class UpdateFinalScore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-final-score';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Call api to update the final scores of all games';

    /**
     * Execute the console command.
     */
    public function handle()
    {
      $this->info('Starting update of final scores for games...');
      try {
        $currentWeek = config('app.current_week');
        $gamesToUpdate = Game::where('week', $currentWeek)->get(); 
        $updatedCount = 0;
        $ur = 'https://site.api.espn.com/apis/site/v2/sports/football/nfl/scoreboard?limit=1000&dates=2025&seasontype=2&week='. config('app.current_week');
        $response = file_get_contents($ur);
        if ($response === FALSE){
          $this->error('an error occured fetching the final scores');
          throw new Exception();
        }
        else{
          $j = json_decode($response, true);
          foreach($j['events'] as $game){
            $homeFinal = $game['competitions'][0]['competitors'][0]['score'];
            $awayFinal = $game['competitions'][0]['competitors'][1]['score'];
            $gameToUpdate = Game::where('gameId', $game['id']);
            $gameToUpdate->update(['homeFinal' => $homeFinal, 'awayFinal' => $awayFinal]);
            $updatedCount++;
          }
          $message = 'Successfully updated the final score columns for ' . $updatedCount . ' games.';
          $this->info($message);
          Log::info($message); // Log success to the application logs
        }
      }
      catch (\Exception $e) {
        $this->error('An error occurred while updating scores: ' . $e->getMessage());
        Log::error('UpdateGames failed: ' . $e->getMessage());
      }
  }
}
