<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use DateTimeImmutable;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
      $date = date_create($this->startTime);
      $date = date_format($date, 'D, M j, g:i');
        return [
          'home' => $this->home,
          'away' => $this->away,
          'over' => $this->over,
          'spread' => $this->spread,
          'startTime' => $date,
          'gameId' => $this->gameId
        ];
    }
}
