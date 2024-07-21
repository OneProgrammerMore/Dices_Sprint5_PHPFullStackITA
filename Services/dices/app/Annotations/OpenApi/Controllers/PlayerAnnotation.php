<?php
declare(strict_types=1);
namespace App\Annotations\OpenApi\Controllers;

class PlayerAnnotation
{
    /**
     * @OA\Post (
     *     path="/login",
     *     operationId="loginUser",
     *     tags={"Player -> Login"},
     *     summary="Logs a user",
     *     description="Logs an user",
     * 
     *     @OA\RequestBody(
     *           @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="email", type="string", 
     *              example="player01@mail.com"
     *             ),
     *              @OA\Property(property="password", type="string", 
     *              example="password"
     *             )
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Success. Returns the user identification and token.",
     * 
     *         @OA\JsonContent(
     *             type="array",
     *             
     *             @OA\Items(
     *                  type="object",
     * 
     *                  @OA\Property(
     *                      property="userid",
     *                      type="string",
     *                      example="aaa-bbb-ccc-ddd-eee",
     *                  ),
     *                  @OA\Property(
     *                      property="name",
     *                      type="string",
     *                      example="player01",
     *                  ),
     *                  @OA\Property(
     *                      property="email",
     *                      type="string",
     *                      example="player01@mail.com",
     *                  ),
     *                  @OA\Property(
     *                      property="jwtoken",
     *                      type="string",
     *                      example="aaa.bbb.ccc",
     *                  ),
     *                  @OA\Property(
     *                      property="role",
     *                      type="string",
     *                      example="player/admin",
     *                  )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error inesperat"
     *     )
     * 
     * )
     */
    public function login() {}
    
    
    /**
     * @OA\Post (
     *     path="/register",
     *     operationId="registerPlayer",
     *     tags={"Player -> RegisterPlayer"},
     *     summary="Register as a Player",
     *     description="Register an user with a player role",
     *     security={{"bearerAuth":{}}},
     * 
     *     @OA\RequestBody(
     *           @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="name", type="string", 
     *              example="player01"
     *             ),
     *              @OA\Property(property="email", type="string", 
     *              example="player01@mail.com"
     *             ),
     *              @OA\Property(property="password", type="string", 
     *              example="password"
     *             ),
     *              @OA\Property(property="password_confirmation", type="string", 
     *              example="password"
     *             ),
     *          )
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Success. Returns the user identification and token.",
     * 
     *         @OA\JsonContent(
     *             type="array",
     *             
     *             @OA\Items(
     *                  type="object",
     * 
     *                  @OA\Property(
     *                      property="userid",
     *                      type="string",
     *                      example="aaa-bbb-ccc-ddd-eee",
     *                  ),
     *                  @OA\Property(
     *                      property="name",
     *                      type="string",
     *                      example="player01",
     *                  ),
     *                  @OA\Property(
     *                      property="email",
     *                      type="string",
     *                      example="player01@mail.com",
     *                  ),
     *                  @OA\Property(
     *                      property="jwtoken",
     *                      type="string",
     *                      example="aaa.bbb.ccc",
     *                  ),
     *                  @OA\Property(
     *                      property="role",
     *                      type="string",
     *                      example="player/admin",
     *                  )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error inesperat"
     *     )
     * 
     * )
     */
    public function store() {}
    
    /**
     * @OA\Post (
     *     path="/registeradmin",
     *     operationId="registerAdmin",
     *     tags={"Player -> RegisterPlayer"},
     *     summary="Register as a Administrator",
     *     description="Register an user with a administrator role",
     * 
     *     @OA\RequestBody(
     *           @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="name", type="string", 
     *              example="admin01"
     *             ),
     *              @OA\Property(property="email", type="string", 
     *              example="admin01@mail.com"
     *             ),
     *              @OA\Property(property="password", type="string", 
     *              example="password"
     *             ),
     *              @OA\Property(property="password_confirmation", type="string", 
     *              example="password"
     *             ),
     *          )
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Success. Returns the user identification and token.",
     * 
     *         @OA\JsonContent(
     *             type="array",
     *             
     *             @OA\Items(
     *                  type="object",
     * 
     *                  @OA\Property(
     *                      property="userid",
     *                      type="string",
     *                      example="aaa-bbb-ccc-ddd-eee",
     *                  ),
     *                  @OA\Property(
     *                      property="name",
     *                      type="string",
     *                      example="player01",
     *                  ),
     *                  @OA\Property(
     *                      property="email",
     *                      type="string",
     *                      example="player01@mail.com",
     *                  ),
     *                  @OA\Property(
     *                      property="jwtoken",
     *                      type="string",
     *                      example="aaa.bbb.ccc",
     *                  ),
     *                  @OA\Property(
     *                      property="role",
     *                      type="string",
     *                      example="player/admin",
     *                  )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error inesperat"
     *     )
     * 
     * )
     */
    public function registerAdmin() {}
    
    
    /**
     * @OA\Get (
     *     path="/players",
     *     operationId="players",
     *     tags={"Player -> ListPlayers"},
     *     summary="List the players",
     *     description="List the players with games as admin",
     *     security={{"bearerAuth":{}}},
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Success. Returns the list of the player with the results."
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="No Game Stored"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error inesperat"
     *     )
     * 
     * )
     */
    public function read() {}
    
    
     /**
     * @OA\Post (
     *     path="/players/{user}",
     *     operationId="updatesName",
     *     tags={"Player -> UpdateName"},
     *     summary="Modify the name of a player",
     *     description="Modifies the name of a user with player role",
     * 
     *     @OA\Parameter(
     *         name="userID",
     *         in="path",
     *         description="User ID",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="uuid"
     *         )
     * 	   ),
     *     @OA\RequestBody(
     *           @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="name", type="string", 
     *              example="player01@mail.com"
     *             ),
     *              @OA\Property(property="password", type="string", 
     *              example="password"
     *             )
     *          )
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Success. The name of the player has been updated.",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error inesperat"
     *     )
     * 
     * )
     */
    public function update() {}
    
    
    /**
     * @OA\Get (
     *     path="/players/ranking",
     *     operationId="ranking",
     *     tags={"Player -> Ranking"},
     *     summary="Returns the ranking of all players.",
     *     description="Returns the ranking of all players.",
     *     security={{"bearerAuth":{}}},
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Success. Returns the ranking of all players."
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="No Game Stored"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error inesperat"
     *     )
     * 
     * )
     */
    public function ranking() {}
    
    
        /**
     * @OA\Get (
     *     path="/players/ranking/loser",
     *     operationId="Loser",
     *     tags={"Player -> Loser"},
     *     summary="Returns the worst of all players.",
     *     description="Returns the worst of all players.",
     *     security={{"bearerAuth":{}}},
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Success. Returns the ranking of all players."
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="No Game Stored"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error inesperat"
     *     )
     * 
     * )
     */
    public function worst() {}
    
    
        /**
     * @OA\Get (
     *     path="/players/ranking/winner",
     *     operationId="winner",
     *     tags={"Player -> Winner"},
     *     summary="Returns the winner of all players.",
     *     description="Returns the winner of all players.",
     *     security={{"bearerAuth":{}}},
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Success. Returns the best player."
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="No Game Stored"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error inesperat"
     *     )
     * 
     * )
     */
    public function best() {}
    
    
}
