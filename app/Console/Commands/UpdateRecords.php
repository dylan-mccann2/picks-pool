<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Record;
use App\Models\Game;
use App\Models\Picks;
use Illuminate\Support\Facades\Log;

class UpdateRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-records';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update each users win loss totals';

    /**
     * Execute the console command.
     */
    public function handle()
    {
      $this->info('Starting update of records for users...');
      try {
        $updatedCount = 0;
        $users = User::all();
        foreach($users as $user){
          $record = Record::where('userId', $user->id)->first();
          $picks = Picks::where('userId', $user->id)->where('week', config('app.current_week'))->first();
          UpdateRecords::calculateOver($picks->overId, $picks->over, $record);

          $updatedCount++;
        }
        $message = 'Successfully updated the records columns for ' . $updatedCount . ' users.';
        $this->info($message);
        Log::info($message); // Log success to the application logs
      } 
      catch (\Exception $e){
        $this->error('An error occurred while updating games: ' . $e->getMessage());
        Log::error('UpdateGames failed: ' . $e->getMessage());
      }
    }


    function calculateOver($gameId, $over, $record){
      $game = Game::where('gameId', $gameId)->first();
      $finalTotal = $game->awayFinal + $game->homeFinal;
      if (($finalTotal - $over) < 0.1 && ($finalTotal - $over > -0.1)){
        // push
        $record->pushes++;
      }
      else if ($finalTotal > $over){
        // over hit
        $record->wins++;
      }
      else {
        // under hit
        $record->losses++;
      }
      $record->save();
    }

    function calculateUnder($gameId, $under, $record){
      $game = Game::where('gameId', $gameId)->first();
      $finalTotal = $game->awayFinal + $game->homeFinal;
      if (($finalTotal - $under) < 0.1 && ($finalTotal - $under > -0.1)){
        // push
        $record->pushes++;
      }
      else if ($finalTotal < $under){
        // under hit
        $record->wins++;
      }
      else {
        // over hit
        $record->losses++;
      }
      $record->save();
    }

    function calculateFavorite($gameId, $team, $spread, $record){
    $game = Game::where('gameId', $gameId)->first();
    if ($team == $game->home) {
      $favoriteFinal = $game->homeFinal;
      $underdogFinal = $game->awayFinal; 
    }
    else{
      $favoriteFinal = $game->awayFinal;
      $underdogFinal = $game->homeFinal;
    }
    if (($favoriteFinal - $underdogFinal - $spread) < 0.1 && ($favoriteFinal - $underdogFinal - $spread) > 0.1){
      // push
      $record->pushes++;
    }
    else if ($favoriteFinal - $spread > $underdogFinal){
      // favorite covered
      $record->wins++;
    }
    else {
      // underdog covered
      $record->losses++;
    }
    $record->save();
  }

  function calculateUnderdog($gameId, $team, $spread, $record){
    $game = Game::where('gameId', $gameId)->first();
    if ($team == $game->home) {
      $underDogFinal = $game->homeFinal;
      $favoriteFinal = $game->awayFinal; 
    }
    else{
      $underdogFinal = $game->awayFinal;
      $favoriteFinal = $game->homeFinal;
    }
    if (($favoriteFinal - $underdogFinal + $spread) < 0.1 && ($favoriteFinal - $underdogFinal + $spread) > 0.1){
      // push
      $record->pushes++;
    }
    else if ($underdogFinal + $spread > $favoriteFinal){
      // underdog covered
      $record->wins++;
    }
    else {
      // favorite covered
      $record->losses++;
    }
    $record->save();
  }
}
