<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Validator;
use App\Models\Throws;
use App\Models\User;
use App\Service\GameService;


class GameController extends Controller
{
	
	private GameService $gameService;
	
	public function __construct()
	{
		$this->gameService = new GameService;
	}
	
    public function store(User $user): JsonResponse
    {
        $dices = $this->gameService->throwDices();
        $throw = $this->gameService->storeDicesInDBByUser($user, $dices);
        
        $game_data_return = array(
			'user_id' => $throw->user_id,
			'dice_1' => $throw->dice_1,
			'dice_2' => $throw->dice_2,
			'dices_sum' => $throw->dices_sum
        );

        return response()->json($game_data_return, 201);
        
    }
	
	public function read(User $user): JsonResponse
	{
		
		$games = $this->gameService->returnGamesPlayedByUser($user);
		return response()->json($games, 200);	
			
	}

    public function destroy(User $user): JsonResponse
    {	
		
		$result = $this->gameService->deleteGamesPlayedByUser($user);
        return response()->json(['message'=>'Games for player deteletd'], 201);
        
    }
}
