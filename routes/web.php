<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\GameController;
use App\Http\Controllers\PicksController;
use App\Http\Controllers\StandingsController;

Route::get('/', function () {
    return Inertia::render('games');
})->name('home');


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';


Route::get('games', [GameController::class, 'index'])->middleware('auth')->name('games');
Route::get('picks', [PicksController::class, 'index'])->middleware('auth')->name('picks');
Route::post('picks', [PicksController::class, 'store'])->middleware('auth');
Route::get('/standings', [StandingsController::class, 'index'])->name('standings.index');