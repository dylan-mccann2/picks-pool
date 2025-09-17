<?php

namespace App\Http\Controllers;

use App\Http\Resources\GameResource;
use App\Models\Game;

use Illuminate\Http\Request;

use Inertia\Inertia;

class GameController extends Controller
{
    //

    public function index() {
      $games = GameResource::collection(Game::where('week', config('app.current_week'))->get());
      return Inertia::render('game/Game', ['games'=>$games]);
    }
}
