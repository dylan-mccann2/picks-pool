<?php

namespace App\Console\Commands;

use App\Models\Game;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateGames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-games';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the "over" and "spread" columns for all games.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting update of "over" and "spread" columns for games...');

        try {
          $currentWeek = config('app.current_week');
          $gamesToUpdate = Game::where('week', $currentWeek)->get(); 
          $updatedCount = 0;

          foreach ($gamesToUpdate as $game) {
            $id = $game->gameId;
            $ur = 'https://sports.core.api.espn.com/v2/sports/football/leagues/nfl/events/'.$id.'/competitions/'.$id.'/odds';
            $response = file_get_contents($ur);
            if ($response === FALSE){
              $this->error('an error occured fetching the new spreads');
              throw new Exception();
            }
            else{
              $j = json_decode($response, true);
              $ou = $j['items'][0]['overUnder'];
              $spread = $j['items'][0]['homeTeamOdds']['current']['pointSpread']['american'];
            }
            $game->update(['over' => $ou, 'spread'=> $spread]);
            $updatedCount++;
          }

          $message = 'Successfully updated the "over" and "spread columns for ' . $updatedCount . ' games.';
          $this->info($message);
          Log::info($message); // Log success to the application logs
        } catch (\Exception $e) {
            $this->error('An error occurred while updating games: ' . $e->getMessage());
            Log::error('UpdateGames failed: ' . $e->getMessage());
        }
    }
}
