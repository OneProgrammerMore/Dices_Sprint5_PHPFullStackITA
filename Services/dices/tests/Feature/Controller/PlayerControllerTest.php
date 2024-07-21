<?php
declare(strict_types=1);

namespace Tests\Feature\Controller\Student;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Testing\TestResponse;

use Laravel\Passport\Passport;

use App\Models\User;
use App\Models\Throws;

class PlayerControllerTest extends TestCase
{
	use DatabaseTransactions;
	
	protected function setUp(): void
    {
        parent::setUp();
    }
	
	/*
	 * Tests - Player Controller:
	 * 1. [ ] best -  GET /players/ranking/winner (2)
	 * 2. [x] login -  POST /login
	 * 3. [x] ranking - GET /players/ranking (1)
	 * 4. [x] read - GET /players
	 * 5. [ ] registerAdmin - POST /registeradmin (0)
	 * 6. [x] store - POST /players  ||  POST /register
	 * 7. [x] update - PUT /players/{user}
	 * 8. [ ] worst - GET /players/loser (3)
	 * 
	 * */
	
	
	
	/**
    * @dataProvider provider_test_register_player
    */
	public function test_register_player_success(array $dataRequest): void
	{
		$response = $this->json('POST', '/api/players/', $dataRequest);
		$response->assertStatus(201);
	}
	
	public static function provider_test_register_player(): array
	{
		$data = array (
			[['name'=> 'nameOne', 'email'=> 'nameOne@mail.com', 'password'=> 'password',  'password_confirmation'=> 'password']]
		);
		
		return $data;
	}
	
	
	/**
    * @dataProvider provider_test_register_player_validation_error
    */
	public function test_register_player_validation_error(array $dataRequest): void
	{
		$response = $this->json('POST', '/api/players/', $dataRequest);
		$response->assertStatus(422);
	}
	
	public static function provider_test_register_player_validation_error(): array
	{
		$data = array (
			[['name'=> 'nameTwo', 'email'=> 'nomail', 'password'=> 'password',  'password_confirmation'=> 'password']],
			[['name'=> 'nameThree', 'email'=> 'nomail', 'password'=> 'password',  'password_confirmation'=> 'passwordWrong']],
			[['name'=> 'nameFour', 'email'=> 'nameTwo@mail.com', 'password'=> 'password',  'password_confirmation'=> 'passwordWrong']],
			[['name'=> 'nameFive', 'email'=> 'nameThree@mail.com', 'password'=> 'password',  'password_confirmation'=> '']],
		);
		
		return $data;
	}
	
	/**
    * @dataProvider provider_test_register_player_name_taken
    */
	public function test_register_player_name_taken(array $dataRequest): void
	{
		$response = $this->json('POST', '/api/players/', $dataRequest);
		$response->assertStatus(201);
		$dataRequest['email'] = $dataRequest['email'] . 'com';
		$response = $this->json('POST', '/api/players/', $dataRequest);
		$response->assertStatus(401);
	}
	
	public static function provider_test_register_player_name_taken(): array
	{
		$data = array (
			[['name'=> 'nameSix', 'email'=> 'nameSix@mail.com', 'password'=> 'password',  'password_confirmation'=> 'password']],
		);
		
		return $data;
	}
	
	/**
    * @dataProvider provider_test_register_player_name_anonymous_success_repeat
    */
	public function test_register_player_name_anonymous_success_repeat(array $dataRequest): void
	{
		$response = $this->json('POST', '/api/players/', $dataRequest);
		$response->assertStatus(201);
		$dataRequest['email'] = $dataRequest['email'] . 'es';
		$response = $this->json('POST', '/api/players/', $dataRequest);
		$response->assertStatus(201);
	}
	
	public static function provider_test_register_player_name_anonymous_success_repeat(): array
	{
		$data = array (
			[['name'=> 'anonymous', 'email'=> 'registerOne@mail.com', 'password'=> 'password',  'password_confirmation'=> 'password']],
			[['name'=> 'Anonymous', 'email'=> 'registerTwo@mail.com', 'password'=> 'password',  'password_confirmation'=> 'password']],
			[['name'=> '', 'email'=> 'registerThree@mail.com', 'password'=> 'password',  'password_confirmation'=> 'password']],
			[['name'=> 'ANONYMOUS', 'email'=> 'registerFour@mail.com', 'password'=> 'password',  'password_confirmation'=> 'password']],
			[['name'=> 'anoNymous', 'email'=> 'registerFive@mail.com', 'password'=> 'password',  'password_confirmation'=> 'password']],
		);
		
		return $data;
	}
	
	
	
	/**
	 * @dataProvider provider_test_login_player
	 */
	public function test_login_player($data): void
	{
		$user = User::factory()->create(['email'=>$data['email'], 'password'=>bcrypt($data['password'])]);
		
		$response = $this->json('POST', '/api/login', $data);
		$response->assertStatus(200);
	}
	
	public static function provider_test_login_player(): array
	{
		$data = array (
			[['email'=> 'nameOne@mail.com', 'password'=> 'password']],
			[['email'=> 'nameTwo@mail.com', 'password'=> 'password!_.FRE']],
		);

		return $data;
	}
	
	/**
	 * @dataProvider provider_test_login_player_validation_error
	 */
	public function test_login_player_validation_error($data): void
	{
		$user = User::factory()->create(['email'=>$data['email'] ?? 'exampleEmail.com', 'password'=>bcrypt($data['password'] ?? 'examplePassword')]);
		
		$response = $this->json('POST', '/api/login', $data);
		$response->assertStatus(422);
	}
	
	public static function provider_test_login_player_validation_error(): array
	{
		$data = array (
			[['email'=> '', 'password'=> 'password']],
			[['email'=> 'nameOne@mail.com', 'password'=> '']],
			[['email'=> 'noEmail', 'password'=> 'password']],
			[['email'=> 'noEmail', 'password'=> '']],
			[['email'=> '', 'password'=> '']],
			[['email'=> 'nameOne@mail.com']],
			[['password'=> 'password']],
		);

		return $data;
	}
	
	/**
	* @dataProvider provider_test_player_modify_name_success
	*/
    //Function to test player creation
    public function test_player_modify_name_success($data): void
    {
		$user = User::factory()->create(['password'=>bcrypt($data['password'])]);
		$user->assignRole('player');

		//Authentuication for Passport
		Passport::actingAs(
			$user
		);
		
		$response = $this->json('PUT', '/api/players/' . $user->id, $data);
		$response->assertStatus(201);
		
		$user->refresh();
		$this->assertEquals($data['name'], $user->name);
		
	}
	
	public static function provider_test_player_modify_name_success(): array
	{
		$data = array (
			[['name'=> 'sayMyName', 'password' => 'password']],
			[['name'=> 'noNamed', 'password' => 'password']]
		);
		return $data;

	}
	
	/**
	* @dataProvider provider_test_player_modify_name_success_anonymous
	*/
    //Function to test player creation
    public function test_player_modify_name_success_anonymous($data): void
    {
		$user = User::factory()->create(['password'=>bcrypt($data['password'])]);
		$user->assignRole('player');

		//Authentuication for Passport
		Passport::actingAs(
			$user
		);
		
		$response = $this->json('PUT', '/api/players/' . $user->id, $data);
		$response->assertStatus(201);
		
		$user->refresh();

		$this->assertEquals(strtoupper($data['name']), strtoupper($user->name));
		
	}
	
	public static function provider_test_player_modify_name_success_anonymous(): array
	{
		$data = array (
			[['name'=> 'Anonymous', 'password' => 'password']],
			[['name'=> 'ANONYMOUS', 'password' => 'password']],
			[['name'=> 'aNONYMOUs', 'password' => 'password']]
		);
		return $data;

	}
	
	/**
	* @dataProvider provider_test_player_modify_name_validation_error
	*/
    //Function to test player creation
    public function test_player_modify_name_validation_error($data): void
    {
		$user = User::factory()->create(['password'=>bcrypt($data['password'] ?? 'examplePassword')]);
		$user->assignRole('player');

		//Authentuication for Passport
		Passport::actingAs(
			$user
		);
		
		$response = $this->json('PUT', '/api/players/' . $user->id, $data);
		$response->assertStatus(422);
		
	}
	
	public static function provider_test_player_modify_name_validation_error(): array
	{
		$data = array (
			[['name'=> '', 'password' => 'password']],
			[['password' => 'password']],
			[['name'=> 'noNamed', 'password' => '']],
			[['name'=> '', 'password' => 'password']],
			[['']],
		);
		return $data;

	}
	
	/**
	* @dataProvider provider_test_player_modify_name_wrong_user_id_failure
	*/
    //Function to test player creation
    public function test_player_modify_name_wrong_user_id_failure($data): void
    {
		$user = User::factory()->create(['password'=>bcrypt($data['password'])]);
		$user->assignRole('player');
		
		$user_2 = User::factory()->create(['password'=>bcrypt($data['password'])]);
		$user_2->assignRole('player');

		//Authentuication for Passport
		Passport::actingAs(
			$user
		);
		
		$response = $this->json('PUT', '/api/players/' . $user_2->id, $data);
		$response->assertStatus(401);
		
	}
	
	public static function provider_test_player_modify_name_wrong_user_id_failure(): array
	{
		$data = array (
			[['name'=> 'sayMyName', 'password' => 'password']],
			[['name'=> 'noNamed', 'password' => 'password']],
			[['name'=> '', 'password' => 'password']],
		);
		return $data;

	}
	/*
    public function test_player_throw_dices(): void
    {
		$user = User::factory()->create();
		$user->assignRole('player');

		//Authentuication for Passport
		Passport::actingAs(
			$user,
			['check-status']
		);
		
		$response = $this->json('POST', '/api/players/' . $user->id . '/games');
		$response->assertStatus(201);
		
		$user->refresh();
		$this->assertEquals($data['name'], $user->name);
	}*/


	public function test_list_player_percentage_success(): void
	{
		$user = User::factory()->create();
		$user->assignRole('admin');
		
		$users_players = User::factory(10)->create();
		$users_players->each->assignRole('player');
		$throws = Throws::factory(100)->create();
		//Authentuication for Passport
		Passport::actingAs(
			$user
		);
		
		$response = $this->json('GET', '/api/players/');
		$response->assertStatus(200);
	}
	
	public function test_list_player_percentage_no_throws_success(): void
	{
		$user = User::factory()->create();
		$user->assignRole('admin');
		
		$users_players = User::factory(10)->create();
		$users_players->each->assignRole('player');

		Passport::actingAs(
			$user
		);
		
		$response = $this->json('GET', '/api/players/');
		$response->assertStatus(204);
	}	
	
	public function test_list_player_percentage_permission_error(): void
	{
		$user = User::factory()->create();
		$user->assignRole('player');
		$response = $this->json('GET', '/api/players/');
		$response->assertStatus(401);
	}
	
	
	
	public function test_ranking_success(): void
	{
		$user = User::factory()->create();
		$user->assignRole('admin');
		
		$users_players = User::factory(10)->create();
		$users_players->each->assignRole('player');
		$throws = Throws::factory(100)->create();
		//Authentuication for Passport
		Passport::actingAs(
			$user
		);
		
		$response = $this->json('GET', '/api/players/ranking');
		$response->assertStatus(200);
	}
	
	public function test_ranking_no_throws_success(): void
	{
		$user = User::factory()->create();
		$user->assignRole('admin');
		
		$users_players = User::factory(10)->create();
		$users_players->each->assignRole('player');
		//Authentuication for Passport
		Passport::actingAs(
			$user
		);
		
		$response = $this->json('GET', '/api/players/ranking');
		$response->assertStatus(204);
	}	
	
	public function test_ranking_permission_error(): void
	{
		$user = User::factory()->create();
		$user->assignRole('player');
		$response = $this->json('GET', '/api/players/ranking');
		$response->assertStatus(401);
	}
	
	
	
	
	public function test_worst_success(): void
	{
		$user = User::factory()->create();
		$user->assignRole('admin');
		
		$users_players = User::factory(10)->create();
		$users_players->each->assignRole('player');
		$throws = Throws::factory(100)->create();
		//Authentuication for Passport
		Passport::actingAs(
			$user
		);
		
		$response = $this->json('GET', '/api/players/ranking/loser');
		$response->assertStatus(200);
	}
	
	public function test_worst_no_throws_success(): void
	{
		$user = User::factory()->create();
		$user->assignRole('admin');
		
		$users_players = User::factory(10)->create();
		$users_players->each->assignRole('player');
		//Authentuication for Passport
		Passport::actingAs(
			$user
		);
		
		$response = $this->json('GET', '/api/players/ranking/loser');
		$response->assertStatus(204);
	}	
	
	public function test_worst_permission_error(): void
	{
		$user = User::factory()->create();
		$user->assignRole('player');
		$response = $this->json('GET', '/api/players/ranking/loser');
		$response->assertStatus(401);
	}
	
	
	public function test_best_success(): void
	{
		$user = User::factory()->create();
		$user->assignRole('admin');
		
		$users_players = User::factory(10)->create();
		$users_players->each->assignRole('player');
		$throws = Throws::factory(100)->create();
		//Authentuication for Passport
		Passport::actingAs(
			$user
		);
		
		$response = $this->json('GET', '/api/players/ranking/winner');
		$response->assertStatus(200);
	}
	
	public function test_best_no_throws_success(): void
	{
		$user = User::factory()->create();
		$user->assignRole('admin');
		
		$users_players = User::factory(10)->create();
		$users_players->each->assignRole('player');
		//Authentuication for Passport
		Passport::actingAs(
			$user
		);
		
		$response = $this->json('GET', '/api/players/ranking/winner');
		$response->assertStatus(204);
	}	
	
	public function test_best_permission_error(): void
	{
		$user = User::factory()->create();
		$user->assignRole('player');
		$response = $this->json('GET', '/api/players/ranking/winner');
		$response->assertStatus(401);
	}
	
	
	
	
	/**
    * @dataProvider provider_test_register_admin
    */
	public function test_register_admin_success(array $dataRequest): void
	{
		$response = $this->json('POST', '/api/registeradmin/', $dataRequest);
		$response->assertStatus(201);
	}
	
	public static function provider_test_register_admin(): array
	{
		$data = array (
			[['name'=> 'nameOne', 'email'=> 'nameOne@mail.com', 'password'=> 'password',  'password_confirmation'=> 'password']]
		);
		
		return $data;
	}
	
	
	/**
    * @dataProvider provider_test_register_admin_validation_error
    */
	public function test_register_admin_validation_error(array $dataRequest): void
	{
		$response = $this->json('POST', '/api/registeradmin/', $dataRequest);
		$response->assertStatus(422);
	}
	
	public static function provider_test_register_admin_validation_error(): array
	{
		$data = array (
			[['name'=> 'nameTwo', 'email'=> 'nomail', 'password'=> 'password',  'password_confirmation'=> 'password']],
			[['name'=> 'nameThree', 'email'=> 'nomail', 'password'=> 'password',  'password_confirmation'=> 'passwordWrong']],
			[['name'=> 'nameFour', 'email'=> 'nameTwo@mail.com', 'password'=> 'password',  'password_confirmation'=> 'passwordWrong']],
			[['name'=> 'nameFive', 'email'=> 'nameThree@mail.com', 'password'=> 'password',  'password_confirmation'=> '']],
		);
		
		return $data;
	}
	
	/**
    * @dataProvider provider_test_register_admin_name_taken
    */
	public function test_register_admin_name_taken(array $dataRequest): void
	{
		$response = $this->json('POST', '/api/registeradmin/', $dataRequest);
		$response->assertStatus(201);
		$dataRequest['email'] = $dataRequest['email'] . 'com';
		$response = $this->json('POST', '/api/registeradmin/', $dataRequest);
		$response->assertStatus(401);
	}
	
	public static function provider_test_register_admin_name_taken(): array
	{
		$data = array (
			[['name'=> 'nameSix', 'email'=> 'nameSix@mail.com', 'password'=> 'password',  'password_confirmation'=> 'password']],
		);
		
		return $data;
	}
	
	/**
    * @dataProvider provider_test_register_admin_name_anonymous_success_repeat
    */
	public function test_register_admin_name_anonymous_success_repeat(array $dataRequest): void
	{
		$response = $this->json('POST', '/api/registeradmin/', $dataRequest);
		$response->assertStatus(201);
		$dataRequest['email'] = $dataRequest['email'] . 'es';
		$response = $this->json('POST', '/api/registeradmin/', $dataRequest);
		$response->assertStatus(201);
	}
	
	public static function provider_test_register_admin_name_anonymous_success_repeat(): array
	{
		$data = array (
			[['name'=> 'anonymous', 'email'=> 'adminOne@mail.com', 'password'=> 'password',  'password_confirmation'=> 'password']],
			[['name'=> 'Anonymous', 'email'=> 'adminTwo@mail.com', 'password'=> 'password',  'password_confirmation'=> 'password']],
			[['name'=> '', 'email'=> 'adminThree@mail.com', 'password'=> 'password',  'password_confirmation'=> 'password']],
			[['name'=> 'ANONYMOUS', 'email'=> 'adminFour@mail.com', 'password'=> 'password',  'password_confirmation'=> 'password']],
			[['name'=> 'anoNymous', 'email'=> 'adminFive@mail.com', 'password'=> 'password',  'password_confirmation'=> 'password']],
		);
		
		return $data;
	}

	

	
}
