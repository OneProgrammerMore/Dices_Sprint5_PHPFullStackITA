<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\Http;


class AdminAuthTest extends TestCase
{
	
	/*
	 * This class AdminAuthTest is used in order to test all admin capabilities,
	 * which include:
	 * 1. registerAdmin feature - To registesr an administrator
	 * 2. GET /players - List users with percentage wins
	 * 3. GET /players/{player_id}/games - List number of plays per user
	 * 4. GET /players/ranking - Returns a ranking of all users
	 * 5. GET /players/ranking/loser - Returns the user with worst score
	 * 6. GET /players/ranking/winner - Returns the user with the best score
	 * 
	 * The data is not passed as a test provider because php unit store first the different
	 * provider's data and then execute all the tests. Therefore the changes commited to this 
	 * data, as an example token api autherizations, cannot be retrieved from this data.
	 * 
	 * Nonetheless the expected status ir submitted by a provider.
	 * 
	 */
	 
	 //Domain to test:
	 public static string $my_domain = "http://127.0.0.1:8000";
	 public static bool $sleepBool = true; 
	 public static int $sleepTime = 200000; //In microseconds
	 //public static string $my_domain = '';
	 
	 //Data used for the tests:
	 public static $admins = array(
		array(
			'name' => 'adminOne',
			'email' => 'adminOne@mail.com',
			'password' => 'adminOnePass',
			'password_confirmation' => 'adminOnePass',
		),
		array(
			'name' => 'adminOne',
			'email' => 'adminTwo@mail.com',
			'password' => 'adminTwoPass',
			'password_confirmation' => 'adminTwoPass',
		),
		array(
			'name' => '',
			'email' => 'adminThree@mail.com',
			'password' => 'adminThreePass',
			'password_confirmation' => 'adminThreePass',
		),
		array(
			'name' => 'Anonymous',
			'email' => 'adminFour@mail.com',
			'password' => 'adminFourPass',
			'password_confirmation' => 'adminFourPass',
		),
		array(
			'name' => 'Anonymous',
			'email' => '',
			'password' => 'adminFivePass',
			'password_confirmation' => 'adminFivePass',
		),
		
		array(
			'name' => 'Anonymous',
			'email' => 'adminSix@mail.com',
			'password' => 'adminSixPass',
			'password_confirmation' => 'adminSixWrongPass',
		),
	
	);
	
	//Counter for admins for login
	public static $counter_admin = 0;
	
	
	/**
	 * @dataProvider provider_test_register_admin
	 */
    //Function to test player creation
	public function test_register_admin($data, $status){	
		
		if(empty($data['password_confirmation'])){
			echo "No Password Confirmation, Validation will fail";
		}
		
		//In order to recive a token it is recived as the body of the response, no JSON file, at least it is what I have read somewhere over the bytebow.
		$response = $this->call('POST', '/api/registeradmin/', $data);
		//Assert Status
		$response->assertStatus($status);
		//In order to avoid Error 429 - Too Many Requests
		if(self::$sleepBool){
			usleep(self::$sleepTime);
		} 
		
		
	}
	public static function provider_test_register_admin(){
		
		$array = array(
			array(
				self::$admins[0],
				201
				),
			array(
				self::$admins[1],
				201
				),
			array(
				self::$admins[2],
				201
				),
			array(
				self::$admins[3],
				201
				),
			array(
				self::$admins[4],
				400
				),
			array(
				self::$admins[5],
				400
				),
			);
		return $array;
	}
	
	
	/**
	 * @dataProvider provider_test_login_admin
	 */
    //Function to test admin login and store tokens
	
	public function test_login_admin($data, $status){	
		//In order to recive a token it is recived as the body of the response, no JSON file, at least it is what I have read somewhere over the bytebow.
		
		$dataForResponse = array(
			'email' => $data['email'],
			'password' => $data['password']
		);
		//$response = $this->call('POST', '/api/login/', $dataForResponse);
		$response = $this->call('POST', self::$my_domain.'/api/login/', $dataForResponse, [], [], [], ['Accept' => 'application/json']);
		
		if(isset(json_decode($response->getContent(), true)['token'])){
			$token_player = json_decode($response->getContent(), true)['token'];
			$id_player = json_decode($response->getContent(), true)['user']['id'];
			if(empty($token_player)){
				self::$admins[self::$counter_admin]['token'] = "EmptyToken";
				echo "Token Empty"."\n";
				echo "COUNTER = ".var_dump(self::$counter_player)."\n";
			}else{
				self::$admins[self::$counter_admin]['token'] = $token_player;
				self::$admins[self::$counter_admin]['id'] = $id_player;
				//self::$admins[self::$counter_player] +=  ['token' => $token_player];
				
			}
		}else{
			self::$admins[self::$counter_admin]['token'] =  "EmptyToken";
		}
		
		self::$counter_admin  = self::$counter_admin + 1;
		
		
		//Assert Status
		$response->assertStatus($status);
		
		//In order to avoid Error 429 - Too Many Requests
		if(self::$sleepBool){
			usleep(self::$sleepTime);
		} 
		
	}
	
	
	public static function provider_test_login_admin(){
		
		$array = array(
			array(
				self::$admins[0],
				200
				),
			array(
				self::$admins[1],
				200
				),
			array(
				self::$admins[2],
				200
				),
			array(
				self::$admins[3],
				200
				),
			array(
				self::$admins[4],
				401
				),
			array(
				self::$admins[5],
				401
				),
			);
		return $array;
	}
	
	
	
	/**
	 * @dataProvider provider_test_list_admin
	 */
    //Function to test admin login and store tokens
	
	public function test_list_admin($data, $index, $status){	
		//In order to recive a token it is recived as the body of the response, no JSON file, at least it is what I have read somewhere over the bytebow.
		
		
		$dataStatic = self::$admins[$index];
		$dataForResponse = array(
			'email' => $dataStatic['email'],
			'password' => $dataStatic['password'],
			'token' => $dataStatic['token'],
		);
		
		
		$response = Http::withHeaders([
			'Accept' => 'application/json',
            'Authorization' => 'Bearer '. $dataForResponse['token']
        ])->get(self::$my_domain .'/api/players/', null);

		//Assert Status
		$this->assertEquals($status, $response->status());
		
		//In order to avoid Error 429 - Too Many Requests
		if(self::$sleepBool){
			usleep(self::$sleepTime);
		} 
		
		
	}
	
	
	public static function provider_test_list_admin(){
		
		$array = array(
			array(
				self::$admins[0],
				0,
				200
				),
			array(
				self::$admins[1],
				1,
				200
				),
			array(
				self::$admins[2],
				2,
				200
				),
			array(
				self::$admins[3],
				3,
				200
				),
			array(
				self::$admins[4],
				4,
				401
				),
			array(
				self::$admins[5],
				5,
				401
				),
			);
		return $array;
	}
	
	
	/**
	 * @dataProvider provider_test_list_player_admin
	 */
    //Function to test admin player games list
	
	public function test_list_player_admin($data, $index, $id_player, $status){	
		//In order to recive a token it is recived as the body of the response, no JSON file, at least it is what I have read somewhere over the bytebow.
		
		
		$dataStatic = self::$admins[$index];
		$dataForResponse = array(
			'email' => $dataStatic['email'],
			'password' => $dataStatic['password'],
			'token' => $dataStatic['token']
		);
		
		
		$response = Http::withHeaders([
			'Accept' => 'application/json',
            'Authorization' => 'Bearer '. $dataForResponse['token']
        ])->get(self::$my_domain . '/api/players/'.$id_player.'/games', null);

		//Assert Status
		$this->assertEquals($status, $response->status());
		
		//In order to avoid Error 429 - Too Many Requests
		if(self::$sleepBool){
			usleep(self::$sleepTime);
		} 
		
	}
	
	
	public static function provider_test_list_player_admin(){
		
		$array = array(
			array(
				self::$admins[0],
				0,
				1,
				200
				),
			array(
				self::$admins[1],
				1,
				2,
				200
				),
			array(
				self::$admins[2],
				2,
				3,
				200
				),
			array(
				self::$admins[3],
				3,
				999,
				400
				),
			array(
				self::$admins[4],
				4,
				312,
				401
				),
			array(
				self::$admins[5],
				5,
				0,
				401
				),
			);
		return $array;
	}
	
	
	
	/**
	 * @dataProvider provider_test_ranking_admin
	 */
    //Function to test admin player games list
	
	public function test_ranking_admin($data, $index, $status){	
		//In order to recive a token it is recived as the body of the response, no JSON file, at least it is what I have read somewhere over the bytebow.
		
		
		$dataStatic = self::$admins[$index];
		$dataForResponse = array(
			'email' => $dataStatic['email'],
			'password' => $dataStatic['password'],
			'token' => $dataStatic['token']
		);
		
		
		$response = Http::withHeaders([
			'Accept' => 'application/json',
            'Authorization' => 'Bearer '. $dataForResponse['token']
        ])->get(self::$my_domain . '/api/players/ranking', null);

		//Assert Status
		$this->assertEquals($status, $response->status());
		
		//In order to avoid Error 429 - Too Many Requests
		if(self::$sleepBool){
			usleep(self::$sleepTime);
		} 
		
	}
	
	
	public static function provider_test_ranking_admin(){
		
		$array = array(
			array(
				self::$admins[0],
				0,
				200
				),
			array(
				self::$admins[1],
				1,
				200
				),
			array(
				self::$admins[2],
				2,
				200
				),
			array(
				self::$admins[3],
				3,
				200
				),
			array(
				self::$admins[4],
				4,
				401
				),
			array(
				self::$admins[5],
				5,
				401
				),
			);
		return $array;
	}
	
	
	/**
	 * @dataProvider provider_test_loser_admin
	 */
    //Function to test admin player games list
	
	public function test_loser_admin($data, $index, $status){	
		//In order to recive a token it is recived as the body of the response, no JSON file, at least it is what I have read somewhere over the bytebow.
		
		
		$dataStatic = self::$admins[$index];
		$dataForResponse = array(
			'email' => $dataStatic['email'],
			'password' => $dataStatic['password'],
			'token' => $dataStatic['token']
		);
		
		
		$response = Http::withHeaders([
			'Accept' => 'application/json',
            'Authorization' => 'Bearer '. $dataForResponse['token']
        ])->get(self::$my_domain . '/api/players/ranking/loser', null);

		//Assert Status
		$this->assertEquals($status, $response->status());
		
		//In order to avoid Error 429 - Too Many Requests
		if(self::$sleepBool){
			usleep(self::$sleepTime);
		} 
		
	}
	
	
	public static function provider_test_loser_admin(){
		
		$array = array(
			array(
				self::$admins[0],
				0,
				200
				),
			array(
				self::$admins[1],
				1,
				200
				),
			array(
				self::$admins[2],
				2,
				200
				),
			array(
				self::$admins[3],
				3,
				200
				),
			array(
				self::$admins[4],
				4,
				401
				),
			array(
				self::$admins[5],
				5,
				401
				),
			);
		return $array;
	}
	
	
	
	/**
	 * @dataProvider provider_test_winner_admin
	 */
    //Function to test admin player games list
	
	public function test_winner_admin($data, $index, $status){	
		//In order to recive a token it is recived as the body of the response, no JSON file, at least it is what I have read somewhere over the bytebow.
		
		
		$dataStatic = self::$admins[$index];
		$dataForResponse = array(
			'email' => $dataStatic['email'],
			'password' => $dataStatic['password'],
			'token' => $dataStatic['token']
		);
		
		
		$response = Http::withHeaders([
			'Accept' => 'application/json',
            'Authorization' => 'Bearer '. $dataForResponse['token']
        ])->get(self::$my_domain . '/api/players/ranking/winner', null);

		//Assert Status
		$this->assertEquals($status, $response->status());
		
		//In order to avoid Error 429 - Too Many Requests
		if(self::$sleepBool){
			usleep(self::$sleepTime);
		} 
		
	}
	
	
	public static function provider_test_winner_admin(){
		
		$array = array(
			array(
				self::$admins[0],
				0,
				200
				),
			array(
				self::$admins[1],
				1,
				200
				),
			array(
				self::$admins[2],
				2,
				200
				),
			array(
				self::$admins[3],
				3,
				200
				),
			array(
				self::$admins[4],
				4,
				401
				),
			array(
				self::$admins[5],
				5,
				401
				),
			);
		return $array;
	}
	
	 
	 
}
