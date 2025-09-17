<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\User;

class StandingsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
      $gb = config('app.current_leader') - $this->wins;
      $name = User::where('id', $this->id)->first()->name;
      return [
        'wins' => $this->wins,
        'losses' => $this->losses,
        'pushes' => $this->pushes,
        'gb' => $gb,
        'id' => $name,
      ];
    }
}
