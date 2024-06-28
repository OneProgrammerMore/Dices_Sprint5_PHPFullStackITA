<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlayerTest extends TestCase
{
	
	//The PlayerTest Class testes the following URIs:
	//1. Player Creation POST /players
	//2. Modify  Player Name PUT /players/{id}
	//3. Player Login
	
    
    /**
	 * @dataProvider provider_test_player_creation
	 */
    //Function to test player creation
    public function test_player_creation($data, $status){
		
		//In order to recive a token it is recived as the body of the response, no JSON file, at least it is what I have read somewhere over the bytebow.
		if(empty($data)){
			$response = $this->call('POST', '/api/players', []);
		}else{
			$response = $this->call('POST', '/api/players', $data);
		}
		//Assert Status
		$response->assertStatus($status);
		
	}
	
	
	static function provider_test_player_creation(){
		
		$array = array(
			//Pos 0 - No Name, Email and passwords, expecting 400 Error
			array(
				null
				, 400),
			//Pos 1 - All Correct - Expecting Success 201
			array(
				array(
				'name' => 'helloApi123',
				'email' => "mai12l@fake.com",
				'password' => 'helloApi123',
				'password_confirmation' => 'helloApi123'
				)
				, 201),
			//Pos 2 - Wrong Email, Expecting Error 400
			array(
				array(
				'name' => 'HelloApi321',
				'email' => "nomail",
				'password' => 'helloApi123',
				'password_confirmation' => 'helloApi123'
				)
				, 400),
			//Pos 3 - No name, others correct - Expecting Anonymous Name and Correct 201 Status
			array(
				array(
				'name' => '',
				'email' => "mai1234l@fake.com",
				'password' => 'helloApi123',
				'password_confirmation' => 'helloApi123'
				)
				, 201),
			//Pos 4 - No name, passwords not equal - Expecting 400 Error
			array(
				array(
				'name' => '',
				'email' => "mai1234l2@fake.com",
				'password' => 'helloApi123',
				'password_confirmation' => 'helloApi1232'
				)
				, 400),
			//Pos 5 - No name, Used Email - Expecting 400 Error
			array(
				array(
				'name' => '',
				'email' => "mai1234l@fake.com",
				'password' => 'helloApi123',
				'password_confirmation' => 'helloApi123'
				)
				, 400),
			//Pos 6 - Anonymous Name, others correct - Expecting Anonymous Name and Correct 201 Status
			array(
				array(
				'name' => 'ANonymous',
				'email' => "mai1234l23@fake.com",
				'password' => 'helloApi123',
				'password_confirmation' => 'helloApi123'
				)
				, 201),
			//Pos 7 - Anonymous name, others correct - Expecting Anonymous Name and Correct 201 Status
			array(
				array(
				'name' => 'ANonymous',
				'email' => "mai1234l234@fake.com",
				'password' => 'helloApi123',
				'password_confirmation' => 'helloApi123'
				)
				, 201),
		);
		
		return $array;
	}
	
	
	 /**
	 * @dataProvider provider_test_player_modify_name
	 */
    //Function to test player creation
    public function test_player_modify_name($data, $id, $status){
		
		//In order to recive a token it is recived as the body of the response, no JSON file, at least it is what I have read somewhere over the bytebow.
		$response = $this->call('PUT', '/api/players/'.$id, $data);
		
		//Assert Status
		$response->assertStatus($status);
		
	}
    
    static function provider_test_player_modify_name(){
		
		$array = array(
			array(
				//Everything right:
				array(
				'name' => 'helloApi124',
				'email' => "mai12l@fake.com",
				'password' => 'helloApi123',
				),
				1, 
				201),
				//Wrong Mail
			array(
				array(
				'name' => 'helloApi124',
				'email' => "mai12lWrong@fake.com",
				'password' => 'helloApi123',
				),
				1, 
				400),
				//Wrong Password
			array(
				array(
				'name' => 'helloApi124',
				'email' => "mai12l@fake.com",
				'password' => 'helloApi123Wrong',
				),
				1, 
				400),
				//No Name
			array(
				array(
				'name' => '',
				'email' => "mai12l@fake.com",
				'password' => 'helloApi123',
				),
				1, 
				400),
			
			);
		return $array;
	}
				
    /**
	 * @dataProvider provider_test_player_login
	 */
    //Function to test player creation
    public function test_player_login($data, $status){
		
		//In order to recive a token it is recived as the body of the response, no JSON file, at least it is what I have read somewhere over the bytebow.
		$response = $this->call('POST', '/api/login/', $data);
		
		//Assert Status
		$response->assertStatus($status);
		
	}
    
    static function provider_test_player_login(){
		
		$array = array(
			//Pos 0 - Yeah It logged in			
			array(
				array(
				'email' => "mai12l@fake.com",
				'password' => 'helloApi123',
				),
				200),
			//Pos 1 - Wrong Password
			array(
				array(
				'email' => "mai12l@fake.com",
				'password' => 'helloApi123Wrong',
				),
				401),
			//Pos 2 - Wrong Email
			array(	
				array(
				'email' => "wrongMail@fake.com",
				'password' => 'helloApi123Wrong',
				), 
				401),
			);
		return $array;
	}
	
    
    
}
