<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Models\Throws;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $player_id)
    {       
        //Validate request
        $data = $request->all();
        
        //Validate $player_id:
		$data['player_id']  = $player_id;
		$validator = Validator::make($data, [
            'player_id' => 'required|exists:users,id',
        ]);
        if($validator->fails()){
            //return response(['error' => $validator->errors(), 'Validation Error'], 400);
            return response()->json(['error' => $validator->errors(), 'Validation Error'], 400);
        }
			
        //Throw the dices of fortune...
        $dice_1 = rand(1,6);
        $dice_2 = rand(1,6);
        //Commented because of improvement in database
        //$dices_sum = $dice_1 + $dice_2;
        
       
        
        $game_data = array(
			'player_id' => $player_id,
			'dice_1' => $dice_1,
			'dice_2' => $dice_2,
			//'dices_sum' => $dices_sum
        );
        
		$throwDB = Throws::create($game_data);
        /* KAUTION  - When using this block  the parameter dices_sum is always null
         * Maybe it it because the database does not update the value at time, before returning it
         * Therefore the value is calculated in the php code as well
         * In order to send it in the response and NOT being null...
         */
        $game_data_return = array(
			'player_id' => $throwDB->player_id,
			'dice_1' => $throwDB->dice_1,
			'dice_2' => $throwDB->dice_2,
			//'dices_sum' => $throwDB->dices_sum,
			'dices_sum' => $throwDB->dice_1 + $throwDB->dice_2
        );

        return response()->json($game_data_return, 201);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
	
	public function read(string $player_id)
	{

		$data = array(
			'player_id' => $player_id
		);
		
		$validator = Validator::make($data, [
            'player_id' => 'required|exists:users,id',
        ]);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors(), 'Validation Error'], 400);
        }

		$games = Throws::where('player_id', '=', $player_id)->get();
		
		//Following if not games played
		if(empty($games) or $games == null){
			return response()->json(["message"=>"No game have been played for the given user"], 400);
		}
		
		return response()->json($games, 200);
		
	}
	
	
	
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $player_id)
    {	
        //Validate $player_id:
		$data ['player_id']  = $player_id;
		
		$validator = Validator::make($data, [
            'player_id' => 'required|exists:users,id',
        ]);
        if($validator->fails()){
            return response(['error' => $validator->errors(), 
            'Validation Error'], 400);
        }
		
        //Delete the games for x player
        Throws::where('player_id', $player_id)->delete();
        
        return response()->json(['message'=>'Games for player deteletd'], 201);
        
    }
}
