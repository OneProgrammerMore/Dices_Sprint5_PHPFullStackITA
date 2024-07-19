<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PlayerController;
use App\Http\Controllers\GameController;

//Register Routes
Route::post('/players', PlayerController::class . '@store')->name('players.create');
Route::post('/register', PlayerController::class . '@store')->name('players.register');
Route::post('/registeradmin', PlayerController::class . '@registerAdmin')->name('admin.create');

//Player authentication for obtaining token:
Route::post('/login', PlayerController::class . '@login')->name('players.login');

//For middleware authentication redirect when user is not authenticated:
Route::prefix('/players/{user}')->middleware(['auth:api','App\Http\Middleware\EnsureUserID', 'role:player'])->group( function(){
	//Modifies the user name:
	Route::put('/', PlayerController::class .'@update')->name('players.update');
	//Throws Dices
	Route::post('/games', GameController::class . '@store')->name('games.create');
	//Deletes the games of x player
	Route::delete('/games', GameController::class . '@destroy')->name('games.destroy');
});

//Routes accesible for admin and player with player_id owner
Route::group(['middleware' => ['auth:api','App\Http\Middleware\EnsureUserIDAndRole']], function(){
	//List number of plays per user
	Route::get('/players/{user}/games', GameController::class . '@read')->name('games.read');
});

//For ADMIN:
Route::prefix('/players')->middleware(['auth:api', 'role:admin'])->group( function(){
	//Returns a list with percentage wins of each user
	Route::get('/', PlayerController::class . '@read')->name('players.read');	
	//Return Ranking
	Route::get('/ranking', PlayerController::class . '@ranking')->name('players.ranking');
	//Returns player with worst score
	Route::get('/ranking/loser', PlayerController::class . '@worst')->name('players.worst');
	//Returns player with best score
	Route::get('/ranking/winner', PlayerController::class . '@best')->name('players.best');
});





