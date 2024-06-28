<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

use Validator;
use App\Models\User;
use App\Models\Throws;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Auth\ApiAuthController;
use Illuminate\Support\Facades\Auth;



class PlayerController extends Controller
{
	
	//Function that checks if the name already existis in the model users
	//Retunrs the name if it is available - or anonymous if it was no name
	//Returns false if the name was taken
	private function checkIfNameAlreadyTaken(?string $name = null): string|bool
	{
		
		//Check if name is empty and add it as "Anonymous"
        if(empty($name)){
			$name = "Anonymous";
		}else if(strtoupper( $name ) != 'ANONYMOUS'){
			//Check if name exists in database Users:
			$userSameName = User::where('name', $name)->first();
			//If it exists exit returning the code error 
			if($userSameName != null){
				return false;
			}
		}
		return $name;
	}
	
	
	private function rankingGet(): array
	{
		$playersColl = Throws::distinct()->pluck('player_id');
		$players_count = Throws::distinct()->count('player_id');
		$playersArray = $playersColl->toArray();
		$resultsArr = [];
		
		foreach($playersColl as $player){
			$player_id = $player;
			$countWins = Throws::where('player_id', $player_id)->where('dices_sum', 7)->count();
			$countTries = Throws::where('player_id', $player_id)->count();
			$percentageWins = $countWins / $countTries;
			$playerUser = User::find($player_id);
			
			$resultsArr [] = array(
				'user_id' => $playerUser->id,
				'wins_perc' => $percentageWins,
				'user_name' => $playerUser->name,
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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //NOT NEEDED FOR THE PROJECT BUT DONE TO PRACTICE
        $users = User::all();
        //return response([ 'users' => UserResource::collection($users), 'message' => 'Successful'], 200);
        return response()->json([ 'users' => UserResource::collection($users), 'message' => 'Successful'], 200);
        
    }
	
	
	public function read(){
		
		$throws = Throws::distinct('player_id')->get();
		$players_count = $throws->count();
		
		$resultsArr = [];
		
		foreach($throws as $throw){
			$player_id = $throw->player_id;
			$countWins = Throws::where('player_id', '=', $throw->player_id)->where('dices_sum', 7)->count();
			$countTries = Throws::where('player_id', '=', $throw->player_id)->count();
			$percentageWins = $countWins / $countTries;
			$player = User::find($throw->player_id);

			$resultsArr [$player_id] = array(
				'wins_perc' => $percentageWins,
				'user_name' => $player->name,
				'user_tries' => $countTries,
				'user_wins' => $countWins
			);
		}
		
		//return response($resultsArr, 200);
		return response()->json($resultsArr, 200);
	}
	
	
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors(), 'Validation Error One'], 400);
        }
        

		$data['name'] = $this->checkIfNameAlreadyTaken($data['name']);
		if($data['name'] == false){
			return response()->json(['message' => 'User Name Taken'],400);
		}  
		
		
		//The user is created in the ApiAuthController within a call to its metodh register
		$apiAuthController = new ApiAuthController();
		$request = new Request($data);
		
		$answerRequest = $apiAuthController->register($request);

        return response()->json($answerRequest->getContent(), $answerRequest->getStatusCode());
    }



	/**
     * Store a newly created resource in storage.
     */
    public function registerAdmin(Request $request)
    {

        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);
        if($validator->fails()){
            //return response(['error' => $validator->errors(), 'Validation Error'], 400);
            return response()->json(['error' => $validator->errors(), 'Validation Error'], 400);
        }
        
		
		$data['name'] = $this->checkIfNameAlreadyTaken($data['name']);
		if(gettype($data['name']) === gettype(response())){
			return $data['name'];
		}
		
		//The user is created in the ApiAuthController within a call to its metodh register
		$apiAuthController = new ApiAuthController();
		$request = new Request($data);
		$answerRequest = $apiAuthController->registerAdmin($request);

        return response()->json($answerRequest->getContent(), $answerRequest->getStatusCode());

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //Validate request
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'min:0|max:255|required',
            'password' => 'required'
        ]);
        if($validator->fails()){
            return response(['error' => $validator->errors(), 
            'Validation Error'], 400);
        }
        
		//Check if Name is already taken and return error if it is
        $data['name'] = $this->checkIfNameAlreadyTaken($data['name']);
		if($data['name'] == false){
			return response()->json(['message' => 'User Name Taken'],400);
		} 
        
        
        
        //Update the name for the given user
        $playerToUpdate = User::find($id);
        
        //Check if the password is correct
		//DONOT WHY BUT IT DOES NOT WORK 
		//ToDO - Version 2 - Check Why Next Commented Block does Not work
		/*
        if( bcrypt($data['password']) != $playerToUpdate->password ){
			return response()->json(['error' => "Password Not Correct"], 400);
		}*/
        //If authentication not succesfull respond with an error message
        $dataAuth = array(
			'email' => $playerToUpdate->email,
			'password' => $data['password']
			//'password' => bcrypt($data['password'])
        );
        $credentials = Validator::make($dataAuth,[
			'email' => 'email|required',
            'password' => 'required',
		]);
        
        Auth::shouldUse('web');
        if (!Auth::attempt($dataAuth)) {
            return response()->json(['error_message' => 'Incorrect Details. 
            Please try again'], 401);
        }
 
        
        if($playerToUpdate != null){
			$playerToUpdate->update(['name'=> $request->name]);
			//Return code status 201
			return response()->json(["message" => "Name Changes Correctly"], 201);
		}else{
			//Yeahp What happend here... learn how to log.... and log any suspicious behaivour....
			return response()->json(['error' => "User ID not found."], 400);
		}
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    
    
    //Throws the lucky luck
    public function throwDices(){
	
	}
    
    //Returns Ranking of players
    public function ranking(){
		
		$resultsArr = $this->rankingGet();

		return response()->json($resultsArr, 200);
	
	}
	
    
    //Returns worst player (Lowest Score)
    public function worst(){
		
		$resultsArr = $this->rankingGet();
		
		if(count($resultsArr) > 0){
			$worst = $resultsArr[count($resultsArr)-1];
			//return response($worst, 200);
			return response()->json(['worst' => $worst], 200);
		}else{
			//return response('No Games Have Been Player', 200);
			return response()->json(['No Games Have Been Player'], 200);
		}
	}
	
	//Returns best player (Highest Score)
	public function best(){
		
		$resultsArr = $this->rankingGet();
		
		if(count($resultsArr) > 0){
			$best = $resultsArr[0];
			//return response($best, 200);
			return response()->json(['best' => $best], 200);
		}else{
			//return response('No Games Have Been Player', 200);
			return response()->json(['No Games Have Been Player'], 200);
		}
		
	}
	
	
	//Function to login into the system and recieve a token from the api
	public function login(Request $request){
		
		$data = $request->all();

        $validator = Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        if ($validator->fails()) {
			return response()->json( ["error"=>"wrong password or email"], 401); 
		}
        
        //Create a request object to use the login ApiAuthFunction
        $requestForLogin = new Request($data);
        $apiAuthController = new ApiAuthController();
        
        $response = $apiAuthController->login($request);
        
        return response()->json(json_decode($response->getContent(),true), $response->getStatusCode()); 

	}
	
    
}
