<?php
declare(strict_types=1);
namespace App\Annotations\OpenApi\Controllers;

class GameAnnotation
{
	
	   /**
     * @OA\Post (
     *     path="/players/{user}/games",
     *     operationId="playsGame",
     *     tags={"Game -> PlaysGame"},
     *     summary="Plays a game as a Player",
     *     description="Plays a game as a Player",
     *     security={{"bearerAuth":{}}},
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
     *     @OA\Response(
     *         response=201,
     *         description="Success. Returns the result of the game.",
     * 
     *         @OA\JsonContent(
     *             type="array",
     *             
     *             @OA\Items(
     *                  type="object",
     * 
     *                  @OA\Property(
     *                      property="dice_1",
     *                      type="integer",
     *                      example="1",
     *                  ),
     *                  @OA\Property(
     *                      property="dice_2",
     *                      type="integer",
     *                      example="6",
     *                  ),
     *                  @OA\Property(
     *                      property="dices_sum",
     *                      type="integer",
     *                      example="7",
     *                  )
     *             )
     *         )
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
    public function store() {}
    
    
      /**
     * @OA\Get (
     *     path="/players/{user}/games",
     *     operationId="listGame",
     *     tags={"Game -> ListGames"},
     *     summary="List the games of a player",
     *     description="List the games of a player",
     *     security={{"bearerAuth":{}}},
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
     *     @OA\Response(
     *         response=200,
     *         description="Success. Returns the list of games for a given user.",
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
     * @OA\Delete (
     *     path="/players/{user}/games",
     *     operationId="deleteGames",
     *     tags={"Game -> DeleteGames"},
     *     summary="Delete the games of a given player",
     *     description="Delete the games of a player",
     *     security={{"bearerAuth":{}}},
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
     *     @OA\Response(
     *         response=201,
     *         description="Success. The games of the given player have been deleted",
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
    public function destroy() {}
	
	

}
