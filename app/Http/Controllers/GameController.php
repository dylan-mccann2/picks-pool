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
      $games = GameResource::collection(Game::all());
      return Inertia::render('game/Game', ['games'=>$games]);
    }
}
