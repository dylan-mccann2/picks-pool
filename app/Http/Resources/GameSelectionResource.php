<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\Picks;

class GameSelectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
      if ($this->spread == 'PK'){

      }
      else if ($this->spread[0] == '+'){
        $underdogString = $this->home . " " . $this->spread;
        $favoriteString = $this->away . " -". substr($this->spread, 1);
      }
      else {
        $favoriteString = $this->home . " " . $this->spread;
        $underdogString = $this->away . " +". substr($this->spread, 1);
      }
        return [
          'over' => $this->away . " @ " . $this->home . " over: " . $this->over,
          'under' => $this->away . " @ " . $this->home . " under: " . $this->over,
          'favorite' => $favoriteString,
          'underdog' => $underdogString,
          'gameId' => $this->gameId
        ];
    }
}
