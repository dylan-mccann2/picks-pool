<?php

namespace App\Http\Controllers;

use App\Http\Resources\GameSelectionResource;
use App\Http\Resources\PicksResource;
use App\Models\Game;
use App\Models\Picks;

use Inertia\Inertia;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use DateTime;
use DateTimeZone;

class PicksController extends Controller
{
    public function index(){
      $now = new DateTime();
      $games = GameSelectionResource::collection(
        Game::where('week', config('app.current_week'))->where('startTime', '>', $now)->get());
      $current = auth()->user()->id;
      $picks = PicksResource::collection(Picks::where('userId', $current)->get()->where('week', config('app.current_week')));
      return Inertia::render('picks/picks', ['options' => $games, 'selections' => $picks]);
    }

    public function store(Request $request){
      $current = auth()->user()->id;
      $input = $request->all();
      $picks = Picks::where('userId', $current)->get()->where('week', config('app.current_week'))->first();
      if ($input['over']!='' && $input['over'] != 'n/a'){
        $picks->overId = $input['over'];
        $over = Game::where('gameId', $picks->overId)->first()->over;
        $picks->over =$over;
      }
      if ($input['under']!='' && $input['under'] != 'n/a'){
        $picks->underId = $input['under'];
        $under = Game::where('gameId', $picks->underId)->first()->over;
        $picks->under = $under;
      }
      if ($input['favorite']!='' && $input['favorite'] != 'n/a'){
        $picks->favoriteId = $input['favorite'];
        $game = Game::where('gameId', $picks->favoriteId)->first();
        $spread = $game->spread;
        $picks->favoriteTeam = ($spread[0] == '-') ? $game->home : $game->away;
        $picks->favoriteSpread = $spread;
      }
      if ($input['underdog']!='' && $input['underdog'] != 'n/a'){
        $picks->underdogId = $input['underdog'];
        $game = Game::where('gameId', $picks->underdogId)->first();
        $spread = $game->spread;
        $picks->underdogTeam = ($spread[0] == '+') ? $game->home : $game->away;
        $picks->underdogSpread = $spread;
      }
      $picks->save();
      return to_route('picks');
    }
}
