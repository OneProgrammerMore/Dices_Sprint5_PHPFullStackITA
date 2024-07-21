<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\JsonResponse;


use Validator;
use App\Models\User;
use App\Models\Throws;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Auth\ApiAuthController;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\StorePlayerRequest;
use App\Http\Requests\LoginPlayerRequest;
use App\Http\Requests\UpdateNameUserRequest;
use App\Service\PlayerService;
use App\Service\AuthService;


class PlayerController extends Controller
{
	private PlayerService $playerService;
	private AuthService $authService;
	
	public function __construct()
	{
		$this->playerService = new PlayerService;
		$this->authService = new AuthService;
	}
	
	public function read(): JsonResponse
	{
		$results = $this->playerService->getListAllUserWithWinsPercentage();
		return response()->json($results, 200);
	}
	
	
    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlayerRequest $request): JsonResponse
    {
		$request['name'] = $this->authService->checkIfNameAllowed($request->input('name'));
		
		$user = $this->authService->registerUser($request->only('name', 'email', 'password'));
		
		$user = $this->authService->addPlayerRoleToUser($user);
		
		$jwtoken = $this->authService->createJWTokenByUser($user);
		
		$role = $this->authService->getRoleByUser($user);
		
        return response()->json([
				'user_id' => $user->id,
				'name' => $user->name,
				'email' => $user->email,
				'jwtoken' => $jwtoken,
				'role' => $role
			]
			, 201);

    }



	/**
     * Store a newly created resource in storage.
     */
    public function registerAdmin(StorePlayerRequest $request): JsonResponse
    {

        $request['name'] = $this->authService->checkIfNameAllowed($request['name']);
		
		$user = $this->authService->registerUser($request->only('name', 'email', 'password'));
		
		$user = $this->authService->addAdminRoleToUser($user);
		
		$jwtoken = $this->authService->createJWTokenByUser($user);
		
		$role = $this->authService->getRoleByUser($user);
		
        return response()->json([
				'user_id' => $user->id,
				'name' => $user->name,
				'email' => $user->email,
				'jwtoken' => $jwtoken,
				'role' => $role
			]
			, 201);


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNameUserRequest $request, User $user): JsonResponse
    {

		//Check if Name is already taken and return error if it is
        $newName = $this->authService->checkIfNameAllowed($request->input('name'));
        
        //Check user password / credentials
        $this->authService->checkUserCredentials($user, $request->input('password'));
        
        //Update user name
        $this->authService->updateUserName($user, $newName);
        
		//Return code status 201
		return response()->json(["message" => "Name Changes Correctly"], 201);
		 
    }
    
    //Returns Ranking of players
    public function ranking(): JsonResponse
    {
		
		$resultsArr = $this->playerService->getRanking();
		
		return response()->json($resultsArr, 200);
	}
	
    
    //Returns worst player (Lowest Score)
    public function worst(): JsonResponse
    {
		
		$ranking = $this->playerService->getRanking();
		
		$worst = $this->playerService->getWorstFromRanking($ranking);
		
		return response()->json(['worst' => $worst], 200);
	}
	
	//Returns best player (Highest Score)
	public function best(): JsonResponse
	{
		
		$ranking = $this->playerService->getRanking();
		$best = $this->playerService->getBestFromRanking($ranking);
		
		return response()->json(['best' => $best], 200);
		
	}
	
	
	//Function to login into the system and recieve a token from the api
	public function login(LoginPlayerRequest $request): JsonResponse
	{
		
		$user = $this->authService->getUserByEmail($request->input('email'));
		
		//Check user password / credentials
        $this->authService->checkUserCredentials($user, $request->input('password'));
		
		$jwtoken = $this->authService->createJWTokenByUser($user);
		
		$role = $this->authService->getRoleByUser($user);
		
        return response()->json([
				'user_id' => $user->id,
				'name' => $user->name,
				'email' => $user->email,
				'jwtoken' => $jwtoken,
				'role' => $role
			]
			, 200);

	}
	
    
}
