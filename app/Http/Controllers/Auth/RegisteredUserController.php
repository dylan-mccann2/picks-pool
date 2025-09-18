<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

use App\Models\Picks;
use App\Models\Record;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        return Inertia::render('auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        Picks::create([
          'userId' => $user->id,
          'week' => config('app.current_week'),
          'over' => 0.0,
          'overId' => '',
          'under' => 0.0,
          'underId' => '',
          'favoriteSpread' => 0.0,
          'favoriteId' => '',
          'favoriteTeam' => '',
          'underdogSpread' => 0.0,
          'underdogId' => '',
          'underdogTeam' => '',
        ]);

        Record::create([
          'wins'  => 0,
          'losses'=> 0,
          'pushes' => 0,
          'userId'=> $user->id,
        ]);

        return to_route('games');
    }
}
