<?php

namespace Tests\Feature\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GamesNoAuthTest extends TestCase
{
	
	//In this test class the following URIs are tested
	//Those are tested without authentication
	//-1. Throw dices POST /players/{id}/games
	//-2. Delete Throws Player DELETE /players/{id}/games
	//-3. 
	
	
	//0. GET /players/
	//1. POST /players/{id}/games
	//2. DELETE /players/{id}/games
	//3. GET /players/{id}/games
	//4. GET /players/ranking
	//5. GET /players/winner
	//6. GET /players/loser
	
	
	/**
	 * @dataProvider provider_test_players_play
	 */
    //Function to test player creation
    public function test_players_play($data, $id, $status){
		
		//In order to recive a token it is recived as the body of the response, no JSON file, at least it is what I have read somewhere over the bytebow.
		$response = $this->call('POST', '/api/players/'.$id.'/games', $data);
		
		//Assert Status
		$response->assertStatus($status);
		
	}
    
    static function provider_test_players_play(){
		
		$array = array(
			//Test Existing User List
			//Pos 0 - Existing User
			array(
				array(
				),
				1, 
				201),
			//Pos 1 - None Existing User
			array(
				array(
				),
				9999, 
				400),
			//Pos 2 - Wrong Input
			array(
				array(
				),
				0, 
				400),
			);
		return $array;
	}
	
	
	
	/**
	 * @dataProvider provider_test_players_deletes
	 */
    //Function to test player creation
    public function test_players_deletes($data, $id, $status){
		
		//In order to recive a token it is recived as the body of the response, no JSON file, at least it is what I have read somewhere over the bytebow.
		$response = $this->call('DELETE', '/api/players/'.$id.'/games', $data);
		
		//Assert Status
		$response->assertStatus($status);
		
	}
    
    static function provider_test_players_deletes(){
		
		$array = array(
			//Test Existing User List
			//Pos 0 - Existing User
			array(
				array(
				),
				1, 
				201),
			//Pos 1 - None Existing User
			array(
				array(
				),
				9999, 
				400),
			//Pos 2 - Wrong Input
			array(
				array(
				),
				0, 
				400),
			);
		return $array;
	}
	
	
	
	
    /**
	 * @dataProvider provider_test_games_list
	 */
    //Function to test player creation
    public function test_player_games_list($data, $status){
		
		//In order to recive a token it is recived as the body of the response, no JSON file, at least it is what I have read somewhere over the bytebow.
		$response = $this->call('GET', '/api/players/', $data);
		
		//Assert Status
		$response->assertStatus($status);
		
	}
    
    static function provider_test_games_list(){
		
		$array = array(
			//Test Existing User List
			//Pos 0 - Existing User
			array(
				array(
				),
				200),
			//Pos 1 - None Existing User
			array(
				array(
				),
				200),
			//Pos 2 - Wrong Input
			array(
				array(
				"name" => "whatever"
				),
				200),
			);
		return $array;
	}
	
	
	
	
	/**
	 * @dataProvider provider_test_players_games_list
	 */
    //Function to test player creation
    public function test_players_games_list($data, $id, $status){
		
		//In order to recive a token it is recived as the body of the response, no JSON file, at least it is what I have read somewhere over the bytebow.
		$response = $this->call('GET', '/api/players/'.$id.'/games', $data);
		
		//Assert Status
		$response->assertStatus($status);
		
	}
    
    static function provider_test_players_games_list(){
		
		$array = array(
			//Test Existing User List
			//Pos 0 - Existing User
			array(
				array(
				),
				1, 
				200),
			//Pos 1 - None Existing User
			array(
				array(
				),
				9999, 
				400),
			//Pos 2 - Wrong Input
			array(
				array(
				),
				0, 
				400),
			);
		return $array;
	}
	
	//
	
	
			
	//Test Ranking:
	/**
	 * @dataProvider provider_test_players_ranking
	 */
    //Function to test player creation
    public function test_players_ranking($data, $status){
		
		//In order to recive a token it is recived as the body of the response, no JSON file, at least it is what I have read somewhere over the bytebow.
		$response = $this->call('GET', '/api/players/ranking', $data);
		
		//Assert Status
		$response->assertStatus($status);
		
	}
    
    static function provider_test_players_ranking(){
		
		$array = array(
			//Test Existing User List
			//Pos 0 - Existing User
			array(
				array(
					"name" => "whatever"
				),
				200),
			//Pos 1 - None Existing User
			array(
				array(
				),
				200),
			//Pos 2 - Wrong Input
			array(
				array(
					"name" => "whatever"
				),
				200),
			);
		return $array;
	}
	
	
	
	//Test Ranking:
	/**
	 * @dataProvider provider_test_players_winner
	 */
    //Function to test player creation
    public function test_players_winner($data, $status){
		
		//In order to recive a token it is recived as the body of the response, no JSON file, at least it is what I have read somewhere over the bytebow.
		$response = $this->call('GET', '/api/players/ranking/winner', $data);
		
		//Assert Status
		$response->assertStatus($status);
		
	}
    
    static function provider_test_players_winner(){
		
		$array = array(
			//Test Existing User List
			//Pos 0 - Existing User
			array(
				array(
				),
				200),
			//Pos 1 - None Existing User
			array(
				array(
				),
				200),
			//Pos 2 - Wrong Input
			array(
				array(
				),
				200),
			);
		return $array;
	}
	
	//Test Ranking:
	/**
	 * @dataProvider provider_test_players_winner
	 */
    //Function to test player creation
    public function test_players_loser($data, $status){
		
		//In order to recive a token it is recived as the body of the response, no JSON file, at least it is what I have read somewhere over the bytebow.
		$response = $this->call('GET', '/api/players/ranking/loser', $data);
		
		//Assert Status
		$response->assertStatus($status);
		
	}
    
    static function provider_test_players_loser(){
		
		$array = array(
			//Test Existing User List
			//Pos 0 - Existing User
			array(
				array(
				),
				200),
			//Pos 1 - None Existing User
			array(
				array(
				),
				200),
			//Pos 2 - Wrong Input
			array(
				array(
					"name" => "whatever"
				),
				200),
			);
		return $array;
	}
	
	
	
}
