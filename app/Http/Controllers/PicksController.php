<?php

namespace App\Http\Controllers;

use App\Http\Resources\GameSelectionResource;
use App\Models\Game;
use App\Models\Picks;

use Inertia\Inertia;

use Illuminate\Http\Request;

class PicksController extends Controller
{
    public function index(){
      $overs = GameSelectionResource::collection(Game::all());
      return Inertia::render('picks/picks', ['picks' => $overs]);
    }

    public function store(Request $request){
      $current = auth()->user()->id;
      echo $current;
      echo $request->data;
      return to_route('picks.index');
    }
}
