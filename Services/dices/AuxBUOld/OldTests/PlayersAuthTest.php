<?php

namespace Tests\Feature\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class PlayersAuthTest extends TestCase
{
	
	
	//public static string $my_domain = "http://127.0.0.1:8000";
	public static string $my_domain = "";
	public static bool $sleepBool = true; 
	public static int $sleepTime = 200000; //In microseconds
	
	//In this class the following features are tested:
	//1. Register as player
	//2. Register as admin
	
	//Players Features:
	//0. Login Player
	//1. Modify Name Player (NOT FOR ADMINS) - PUT /players/id
	//2. Throw Dices - POST /players/{id}/games
	//3. DELETE /players/{id}/games
	
	//Admin Features
	//0. Login Admin
	//1. List users with percentage wins - GET /players
	//2. List Number of plays per user - GET /players/{id}/games
	//3. Returns Ranking - GET /players/ranking
	//4. Worst player - GET /players/loser
	//5. Best player - GET /players/winner
	
	public string $tokens_admin;
	public string $passwords_admin;
	public string $emails_admin;
	public string $names_admin;
	public $admins;
	public int $counter_admin = 0;
	
	public string $tokens_player;
	public string $passwords_player;
	public string $emails_player;
	public string $names_players;
	//public $players;
	public static int $counter_player = 0;
	public static int $counter_player_mod_name = 0;
	
	public static $players = array(
		array(
			'name' => 'playerOne',
			'email' => 'playerOne@mail.com',
			'password' => 'playerOnePass',
			'password_confirmation' => 'playerOnePass',
			'new_name' => 'playerOneNewName',
			//'token' => ''
		),
		array(
			'name' => '',
			'email' => 'playerTwo@mail.com',
			'password' => 'playerTwoPass',
			'password_confirmation' => 'playerTwoPass',
			'new_name' => 'playerTwoNewName',
			//'token' => ''
		),
		array(
			'name' => 'Anonymous',
			'email' => 'playerThree@mail.com',
			'password' => 'playerThreePass',
			'password_confirmation' => 'playerThreePass',
			'new_name' => 'playerThreeNewName',
			//'token' => ''
		),
	
	);
	
	
	
	//public static string $my_domain = "";
	/**
	 * @dataProvider provider_test_register_player
	 */
    //Function to test player creation
	
	public function test_register_player($data, $status){	
		
		if(empty($data['password_confirmation'])){
			echo "No Password Confirmation, Validation will fail";
		}
		
		//In order to recive a token it is recived as the body of the response, no JSON file, at least it is what I have read somewhere over the bytebow.
		$response = $this->call('POST', self::$my_domain.'/api/register/', $data);
		//Assert Status
		$response->assertStatus($status);
		
		//In order to avoid Error 429 - Too Many Requests
		if(self::$sleepBool){
			usleep(self::$sleepTime);
		} 
		
		
	}
	
	
	public static function provider_test_register_player(){
		
		$array = array(
			array(
				self::$players[0],
				201
				),
			array(
				self::$players[1],
				201
				),
			array(
				self::$players[2],
				201
				),
			);
		return $array;
	}
	
	
	//Login Players

	/**
	 * @dataProvider provider_test_login_player
	 */
    //Function to test player login and store tokens
	
	public function test_login_player($data, $status){	
		//In order to recive a token it is recived as the body of the response, no JSON file, at least it is what I have read somewhere over the bytebow.
		
		$dataForResponse = array(
			'email' => $data['email'],
			'password' => $data['password']
		);
		$response = $this->call('POST',  self::$my_domain.'/api/login/', $dataForResponse);
		//Assert Status
		$response->assertStatus($status);
		
		$token_player = json_decode($response->getContent(), true)['token'];
		$id_player = json_decode($response->getContent(), true)['user']['id'];
		if(empty($token_player)){
			self::$players[self::$counter_player]['token'] = "EmptyToken";
			echo "Token Empty"."\n";
			echo "COUNTER = ".var_dump(self::$counter_player)."\n";
		}else{
			self::$players[self::$counter_player]['token'] = $token_player;
			self::$players[self::$counter_player]['id'] = $id_player;
			//self::$players[self::$counter_player] +=  ['token' => $token_player];
			
		}
		self::$counter_player  = self::$counter_player  + 1;
		
		//In order to avoid Error 429 - Too Many Requests
		if(self::$sleepBool){
			usleep(self::$sleepTime);
		} 
		
	}
	
	
	public static function provider_test_login_player(){
		
		$array = array(
			array(
				self::$players[0],
				200
				),
			array(
				self::$players[1],
				200
				),
			array(
				self::$players[2],
				200
				),
			);
		return $array;
	}
	
	
	//Players Modify Name:
	
	 /**
	 * @dataProvider provider_test_player_modify_name
	 */
    //Function to test player creation
    public function test_player_modify_name($index, $id, $status){
		
		//Workaround because public static array not updating itself when given in the provider:
		$dataStatic = self::$players[$index];
		$dataForResponse = array(
			'name' => $dataStatic['new_name'],
			'email' => $dataStatic['email'],
			'password' => $dataStatic['password'],
			'token' => $dataStatic['token'],
			'id' => $dataStatic['id']
		);
		
		if($id == 0){
			$newId = rand(1,9999);
			while($newId == $dataForResponse['id']){
				$newId = rand(1,9999);
			}
			$dataForResponse['id'] = $newId;
		}
		
		//In order to recive a token it is recived as the body of the response, no JSON file, at least it is what I have read somewhere over the bytebow.
		//$response = $this->call('PUT', '/api/players/'.$id, $dataForResponse);
		
		//$this->json('PUT', '/api/players/'.$id, $dataForResponse);
		/*
		$response = $this->withHeaders([
			'Accept' => 'application/json',
            'Authorization' => 'Bearer '. $data['token'],
        ])->json('PUT', '/api/players/'.$id, $dataForResponse);
        */
        
        $response = Http::withHeaders([
			'Accept' => 'application/json',
            'Authorization' => 'Bearer '. $dataForResponse['token']
        ])->put(self::$my_domain . '/api/players/'.$dataForResponse['id'], $dataForResponse);
        
        //$response = Http::withToken( $data['token'])->put(self::$my_domain . '/api/players/'.$id, $dataForResponse);

		//Assert Status
		//$response->assertStatus($status);
		$this->assertEquals($status, $response->status());
		
		//self::$counter_player_mod_name ++ ;
		
		//In order to avoid Error 429 - Too Many Requests
		if(self::$sleepBool){
			usleep(self::$sleepTime);
		} 
		
		
		
	}
    
    public static function provider_test_player_modify_name(){
		
		$array = array(
			array(
				//Everything right:
				0,
				1, //1 means user id - 0 means different as user id
				201),
				//Wrong Mail
			array(
				1,
				1, 
				201),
				//Wrong Password
			array(
				2, //index of array self::$players[2],
				0, 
				401),			
			);
		return $array;
	}
	
	
	
	
	
	//Players Throw Dices:
	
	 /**
	 * @dataProvider provider_test_player_throw_dices
	 */
    //Function to test player creation
    public function test_player_throw_dices($index, $id, $status){
		
		//Workaround because public static array not updating itself when given in the provider:
		$dataStatic = self::$players[$index];
		$dataForResponse = array(
			//'name' => $dataStatic['new_name'],
			//'email' => $dataStatic['email'],
			//'password' => $dataStatic['password'],
			'token' => $dataStatic['token'],
			'id' => $dataStatic['id']
		);
		
		if($id == 0){
			$newId = rand(1,9999);
			while($newId == $dataForResponse['id']){
				$newId = rand(1,9999);
			}
			$dataForResponse['id'] = $newId;
		}
       
		for($i=0; $i<18; $i++){
			$response = Http::withHeaders([
				'Accept' => 'application/json',
				'Authorization' => 'Bearer '. $dataForResponse['token']
			])->post(self::$my_domain . '/api/players/'.$dataForResponse['id'].'/games', $dataForResponse);
			
			//Assert Status
			$this->assertEquals($status, $response->status());
			
		}
		
		//In order to avoid Error 429 - Too Many Requests
		if(self::$sleepBool){
			usleep(self::$sleepTime);
		} 
		
		//self::$counter_player_mod_name ++ ;
		
		
	}
    
    public static function provider_test_player_throw_dices(){
		
		$array = array(
			array(
				//Everything right:
				0,
				1, //1 means user id - 0 means different as user id
				201),
				//Wrong Mail
			array(
				1,
				1, 
				201),
				//Wrong Password
			array(
				2, //index of array self::$players[2],
				0, 
				401),			
			);
		return $array;
	}
	
	
	/**
	 * @dataProvider provider_test_list_player_player
	 */
    //Function to test admin player games list
	
	public function test_list_player_player($index, $id, $status){	
		//In order to recive a token it is recived as the body of the response, no JSON file, at least it is what I have read somewhere over the bytebow.
		
		
		//Workaround because public static array not updating itself when given in the provider:
		$dataStatic = self::$players[$index];
		$dataForResponse = array(
			//'name' => $dataStatic['new_name'],
			//'email' => $dataStatic['email'],
			//'password' => $dataStatic['password'],
			'token' => $dataStatic['token'],
			'id' => $dataStatic['id']
		);
		
		if($id == 0){
			$newId = rand(1,9999);
			while($newId == $dataForResponse['id']){
				$newId = rand(1,9999);
			}
			$dataForResponse['id'] = $newId;
		}
			
			
		$response = Http::withHeaders([
			'Accept' => 'application/json',
            'Authorization' => 'Bearer '. $dataForResponse['token']
        ])->get(self::$my_domain . '/api/players/'. $dataForResponse['id'] .'/games', null);

		$this->assertEquals($status, $response->status());
		
		//In order to avoid Error 429 - Too Many Requests
		if(self::$sleepBool){
			usleep(self::$sleepTime);
		} 
		

	}
	
	
	public static function provider_test_list_player_player(){
		
		$array = array(
			array(
				//Everything right:
				0,
				1, //1 means user id - 0 means different as user id
				200),
				//Wrong Mail
			array(
				1,
				1, 
				200),
				//Wrong Password
			array(
				2, //index of array self::$players[2],
				0, 
				401),			
			);
		return $array;
	}
	
	
	
	
	
	
	//Players Throw Dices:
	
	 /**
	 * @dataProvider provider_test_player_delete
	 */
    //Function to test player creation
    public function test_player_delete($index, $id, $status){
		
		//Workaround because public static array not updating itself when given in the provider:
		$dataStatic = self::$players[$index];
		$dataForResponse = array(
			//'name' => $dataStatic['new_name'],
			//'email' => $dataStatic['email'],
			//'password' => $dataStatic['password'],
			'token' => $dataStatic['token'],
			'id' => $dataStatic['id']
		);
		
		if($id == 0){
			$newId = rand(1,9999);
			while($newId == $dataForResponse['id']){
				$newId = rand(1,9999);
			}
			$dataForResponse['id'] = $newId;
		}
		//In order to avoid Error 429 - Too Many Requests
		if(self::$sleepBool){
			usleep(self::$sleepTime);
		} 
		
		for($i=0; $i<18; $i++){
			$response = Http::withHeaders([
				'Accept' => 'application/json',
				'Authorization' => 'Bearer '. $dataForResponse['token']
			])->post(self::$my_domain . '/api/players/'.$dataForResponse['id'].'/games', $dataForResponse);
			
			//Assert Status
			$this->assertEquals($status, $response->status());
		}
		
		//In order to avoid Error 429 - Too Many Requests
		if(self::$sleepBool){
			usleep(self::$sleepTime);
		} 
		
		
	}
    
    public static function provider_test_player_delete(){
		
		$array = array(
			array(
				//Everything right:
				0,
				1, //1 means user id - 0 means different as user id
				201),
				//Wrong Mail
			array(
				1,
				1, 
				201),
				//Wrong Password
			array(
				2, //index of array self::$players[2],
				0, 
				401),			
			);
		return $array;
	}
	
	
	
	
	
	

}
