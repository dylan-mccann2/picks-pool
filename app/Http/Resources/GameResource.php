<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
          'home' => $this->home,
          'away' => $this->away,
          'over' => $this->over,
          'spread' => $this->spread,
          'startTime' => $this->startTime,
          'gameId' => $this->gameId
        ];
    }
}
