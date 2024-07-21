<?php
declare(strict_types=1);

namespace App\Service;

use App\Models\User;
use App\Models\Throws;

use App\Exceptions\ThrowNotStoredInDBException;
use App\Exceptions\NoGamesStoredForUserInDBException;

use Illuminate\Database\Eloquent\Collection;


class GameService
{

	public function __construct()
	{
		
	}

	public function throwDices(): array
	{
		$dice_1 = rand(1,6);
        $dice_2 = rand(1,6);
        return [ 'dice_1' => $dice_1, 'dice_2' => $dice_2]; 
	}
	
	public function storeDicesInDBByUser(User $user, array $dices): Throws
	{
		$game_data = array(
			'user_id' => $user->id,
			'dice_1' => $dices['dice_1'],
			'dice_2' => $dices['dice_2']
        );
        
        $throwDB = Throws::create($game_data);
        $throwDB->refresh();
        
        if(!$throwDB){
			//This seems it will be never throw, it will throw a QueryException, but nonetheless...
			throw new ThrowNotStoredInDBException($studentID, $dices);
		}
        
        return $throwDB;
	}
	
	public function returnGamesPlayedByUser(User $user): Collection
	{
		$games = Throws::where('user_id', $user->id)->get();
		
		if($games->count() == 0){
			throw new NoGamesStoredForUserInDBException($user->id);
		}
		return $games;
	}
	
	public function deleteGamesPlayedByUser(User $user): bool
	{
		
		Throws::where('user_id', $user->id)->delete();
		
		return true;
	}
	
}
