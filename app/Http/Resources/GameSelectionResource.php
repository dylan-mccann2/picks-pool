<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Models\Picks;

class GameSelectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
          'over' => $this->away . " @ " . $this->home . " over: " . $this->over,
          'under' => $this->away . " @ " . $this->home . " under: " . $this->over,
          'gameId' => $this->gameId
        ];
    }
}
