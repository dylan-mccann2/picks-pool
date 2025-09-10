<?php
  namespace App\Http\Controllers;
  
  use App\Models\User;
  use Inertia\Inertia;
  use Illuminate\Http\Request;
  
  class StandingsController extends Controller {
    public function index() {
      $users = User::with('picks.game')->get();

      $standings = $users->map(function ($user) {
          $correctPicks = $user->picks->filter(function ($pick) {
              return $pick->is_correct; // You'll need to add this logic to your Pick model
          })->count();

          return [
              'name' => $user->name,
              'correct_picks' => $correctPicks,
          ];
      })->sortByDesc('correct_picks')->values();

      return Inertia::render('standings/index', [
          'standings' => $standings,
      ]);
    }
  }