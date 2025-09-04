<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


use App\Models\Game;

class PicksResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
      if ($this->overId){
        $game = Game::where('gameId', $this->overId)->first();
        $homeTeamOver = $game->home;
        $awayTeamOver = $game->away;
      }
      else{
        $homeTeamOver = 'n/a';
        $awayTeamOver = 'n/a';
      }
      if ($this->underId){
        $game = Game::where('gameId', $this->underId)->first();
        $homeTeamUnder = $game->home;
        $awayTeamUnder = $game->away;
      }
      else{        
        $homeTeamUnder = 'n/a';
        $awayTeamUnder = 'n/a';
      }

        return [
          'over' => $this->overId,
          'overString' => $awayTeamOver . " @ " . $homeTeamOver . " over: " . $this->over,  
          'under' => $this->underId,
          'underString' => $awayTeamUnder . " @ " . $homeTeamUnder . " under: " . $this->under,
          'favorite' => $this->favoriteId,
          'favoriteString' => $this->favoriteTeam . ' -' . substr($this->favoriteSpread,1),
          'underdog' => $this->underdogId,
          'underdogString' => $this->underdogTeam . ' +' . substr($this->underdogSpread,1),
        ];
    }
}