<?php
  namespace App\Http\Controllers;
  
  use App\Models\User;
  use Inertia\Inertia;
  use Illuminate\Http\Request;

  use App\Http\Resources\StandingsResource;
  use App\Models\Record;
  
  class StandingsController extends Controller {
    public function index() {
      $standings = StandingsResource::collection(Record::all()->sortByDesc('wins')->values());
      return Inertia::render('standings/Standings', [
          'standings' => $standings,
      ]);
    }
  }