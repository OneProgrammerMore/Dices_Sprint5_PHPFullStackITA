<?php
declare(strict_types=1);

namespace App\Service;

use App\Models\User;
use App\Models\Throws;

use App\Exceptions\ThrowNotStoredInDBException;
use App\Exceptions\NoGamesStoredForUserInDBException;
use App\Exceptions\NoGamesStoredInDBException;


class PlayerService
{

	public function __construct()
	{

	}

	public function getRanking(): array
	{
		$playersColl = Throws::distinct()->pluck('user_id');
		$players_count = Throws::distinct()->count('user_id');
		$playersArray = $playersColl->toArray();
		$resultsArr = [];
		
		if($playersColl->count() == 0){
			throw new NoGamesStoredInDBException();
		}
		
		
		
		foreach($playersColl as $player){
			$user_id = $player;
			$countWins = Throws::where('user_id', $user_id)->where('dices_sum', 7)->count();
			$countTries = Throws::where('user_id', $user_id)->count();
			if($countTries != 0){
				$percentageWins = $countWins / $countTries;
			}else{
				$percentageWins = 0;
			}
			$user = User::find($user_id);
			
			$resultsArr [] = array(
				'user_id' => $user->id,
				'wins_perc' => $percentageWins,
				'user_name' => $user->name,
				'user_tries' => $countTries,
				'user_wins' => $countWins,
				'count' => $players_count
			);
		}
		
		//Sort array by $percentageWins:
		usort(
			$resultsArr, 
			function ($a, $b){
				return ($a['wins_perc'] > $b['wins_perc'] ) ? -1 : 1;
			}
		);
		
		return $resultsArr;
		
	
	}
	
	
	public function getListAllUserWithWinsPercentage(): array
	{
		
		
		$throws = Throws::distinct('user_id')->get();
		$players_count = $throws->count();
		
		if($throws->count() == 0){
			throw new NoGamesStoredInDBException();
		}
		
		
		$resultsArr = [];
		
		foreach($throws as $throw){
			$player_id = $throw->user_id;
			$countWins = Throws::where('user_id', '=', $throw->user_id)->where('dices_sum', 7)->count();
			$countTries = Throws::where('user_id', '=', $throw->user_id)->count();
			$percentageWins = $countWins / $countTries;
			$player = User::find($throw->user_id);

			$resultsArr [$player_id] = array(
				'wins_perc' => $percentageWins,
				'user_name' => $player->name,
				'user_tries' => $countTries,
				'user_wins' => $countWins
			);
		}
		
		return $resultsArr;
	}
	
	
	public function getWorstFromRanking(array $ranking): array
	{
		$worst = null;
		if(count($ranking) > 0){
			$worst = $ranking[count($ranking)-1];
		}
		
		if(!$worst){
			throw new NoGamesStoredInDBException();
		}
		
		return $worst;
		
	}
	
	public function getBestFromRanking(array $ranking): array
	{
		$best = null;
		if(count($ranking) > 0){
			$best = $ranking[0];
		}
		
		if(!$best){
			throw new NoGamesStoredInDBException();
		}
		
		return $best;
		
	}
	
		
	
}
