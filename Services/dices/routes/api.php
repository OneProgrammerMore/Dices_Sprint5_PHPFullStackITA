<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PlayerController;
use App\Http\Controllers\GameController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


//ROUTES WITH MIDDLEWARE - PASSPORT AND SPATIE

//NO AUTH or ROLE
Route::post('/players', PlayerController::class . '@store')->name('players.create');
Route::post('/register', PlayerController::class . '@store')->name('players.register');
Route::post('/registeradmin', PlayerController::class . '@registerAdmin')->name('admin.create');

//Player authentication for obtaining token:
Route::post('/login', PlayerController::class . '@login')->name('players.login');

//For middleware authentication redirect when user is not authenticated:
Route::group(['middleware' => ['auth:api','App\Http\Middleware\EnsureUserID', 'role:player']], function(){
	//Modifies the user name:
	Route::put('/players/{player_id}', PlayerController::class .'@update')->name('players.update');
	//Throws Dices
	Route::post('/players/{player_id}/games', GameController::class . '@store')->name('games.create');
	//Deletes the games of x player
	Route::delete('/players/{player_id}/games', GameController::class . '@destroy')->name('games.destroy');
});



//Routes accesible for admin and player with player_id owner
Route::group(['middleware' => ['auth:api','App\Http\Middleware\EnsureUserIDAndRole']], function(){
	//For Player And Admin
	//List number of plays per user
	Route::get('/players/{player_id}/games', GameController::class . '@read')->name('games.read');
});


Route::group(['middleware' => ['auth:api', 'role:admin']], function(){
	//For ADMIN:
	//Returns a list with percentage wins of each user
	Route::get('/players', PlayerController::class . '@read')->name('players.read');	
	

	//Return Ranking
	Route::get('/players/ranking', PlayerController::class . '@ranking')->name('players.ranking');

	//Returns player with worst score
	Route::get('/players/ranking/loser', PlayerController::class . '@worst')->name('players.worst');
	//Returns player with best score
	Route::get('/players/ranking/winner', PlayerController::class . '@best')->name('players.best');
});





