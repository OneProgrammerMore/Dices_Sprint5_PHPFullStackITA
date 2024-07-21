<?php
declare(strict_types=1);

namespace Tests\Feature\Service;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;
use Mockery;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Throws;

use App\Service\AuthService;

use App\Exceptions\ThrowNotStoredInDBException;
use App\Exceptions\NoGamesStoredForUserInDBException;
use App\Exceptions\RegisterUserDataNotCorrectException;
use App\Exceptions\UserNotFoundByEmailException;
use App\Exceptions\NameAlreadyTakenException;
use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\JWTokenNotGeneratedException;



class AuthServiceTest extends TestCase
{
	use DatabaseTransactions;
	
	private $service;

	public function setUp(): void
	{
		parent::setUp();
		$this->service = new AuthService();
	}

	
	
	
	public function testCreateJWTokenException(){
		
        $returnUser = User::factory()->create();

        $userMock = Mockery::mock($returnUser)->makePartial();

		$object = new \stdClass();
		$object->accessToken = '';
        $userMock->shouldReceive('createToken')
                 ->once()
                 ->andReturn($object);
		//$this->app->instance('overload:App\Models\User', $userMock);


		$this->expectException(JWTokenNotGeneratedException::class);
		
		$jwt = $this->service->createJWTokenByUser($userMock);
		
		 Mockery::close(); 
	}





	/**
	 * @dataProvider checkUserCredentialsSuccessProvider
	 *
	 */
	public function testCheckUserCredentialsSuccess(string $email, string $password)
	{
		$user = User::factory()->create(['email' => $email, 'password' => bcrypt($password)]);

		$result = $this->service->checkUserCredentials($user, $password);

		$this->assertEquals(true, $result);
	}

	static function checkUserCredentialsSuccessProvider(): array
	{
		$array = array(
			array(
				'emailOne@mail.com',
				'password'
			),
			array(
				'emailTwo@mail.com',
				'password'
			),
			array(
				'emailThree@mail.com',
				'passOnePass'
			)
		);
		return $array;
	}
	
	
	/**
	 * @dataProvider checkUserCredentialsExceptionProvider
	 *
	 */
	public function testCheckUserCredentialsExceptionWrongPassword(string $email, string $password)
	{
		$user = User::factory()->create(['email' => $email, 'password' => bcrypt($password)]);
		
		$this->expectException(InvalidCredentialsException::class);
		
		$result = $this->service->checkUserCredentials($user, 'wrongPassword');

		//$this->assertEquals(true, $result);
	}

	static function checkUserCredentialsExceptionProvider(): array
	{
		$array = array(
			array(
				'email4@mail.com',
				'password'
			),
			array(
				'email5@mail.com',
				'password'
			),
			array(
				'email6@mail.com',
				'passOnePass'
			)
		);
		return $array;
	}
	
	
	
	/**
	 * @dataProvider getUserByEmailProvider
	 *
	 */
	public function testGetUserByEmailSuccess(string $email, string $password)
	{
		$user = User::factory()->create(['email' => $email, 'password' => bcrypt($password)]);

		$user_result = $this->service->getUserByEmail($email);
			
		$this->assertEquals($user->getAttributes(), $user_result->getAttributes());
	}

	static function getUserByEmailProvider(): array
	{
		$array = array(
			array(
				'email30@mail.com',
				'password'
			),
			array(
				'email31@mail.com',
				'password'
			),
			array(
				'email32@mail.com',
				'passOnePass'
			)
		);
		return $array;
	}
	
	public function testGetUserByEmailException()
	{
		
		$this->expectException(UserNotFoundByEmailException::class);
		
		$result = $this->service->getUserByEmail('nonExistingEmai1234@mail.non');
	}


	/**
	 * @dataProvider checkIfNameIsAllowedProvider
	 *
	 */
	public function testCheckIfNameIsAllowedSuccess(string $name)
	{
			
		$result = $this->service->checkIfNameAllowed($name);
			
		$this->assertEquals(true, $result);
	}

	static function checkIfNameIsAllowedProvider(): array
	{
		$array = array(
			array(
				'name0007'
			),
			array(
				'name0008'
			),
			array(
				'name0009'
			)
		);
		return $array;
	}
	
	/**
	 * @dataProvider checkIfNameIsAllowedExceptionProvider
	 *
	 */
	public function testCheckIfNameIsAllowedException(string $name)
	{
		$user = User::factory()->create(['name'=>$name]);
		
		$this->expectException(NameAlreadyTakenException::class);
		
		$result = $this->service->checkIfNameAllowed($name);
	}
	
	static function checkIfNameIsAllowedExceptionProvider(): array
	{
		$array = array(
			array(
				'nonExistingEmai1234'
			),
			array(
				'nonExistingEmai1235'
			),
			array(
				'nonExistingEmai1236'
			)
		);
		return $array;
	}
	
	/**
	 * @dataProvider checkIfNameIsAllowedAnonymousProvider
	 *
	 */
	public function testCheckIfNameIsAllowedAnonymousSuccess(string $name)
	{
		$user = User::factory()->create(['name'=>$name]);
		$result = $this->service->checkIfNameAllowed($name);
		$this->assertEquals(true, $result);
	}
	
	static function checkIfNameIsAllowedAnonymousProvider(): array
	{
		$array = array(
			array(
				''
			),
			array(
				'Anonymous'
			),
			array(
				'Anonymous'
			),
			array(
				'AnonYmous'
			),
			array(
				'ANONYMOUS'
			),
			array(
				'Anonymous'
			)
			
		);
		return $array;
	}
	
	
	
	
	
	
	/**
	 * @dataProvider registerUserSuccessProvider
	 *
	 */
	public function testRegisterUserSuccess(array $data)
	{
			
		$result = $this->service->registerUser($data);
			
		$this->assertInstanceOf(User::class, $result);
	}

	static function registerUserSuccessProvider(): array
	{
		$array = array(
			array(
				['name'=>'name1001', 'email'=>'email1001@mail.com', 'password'=>'password']
			),
			array(
				['name'=>'name1002', 'email'=>'email1002@mail.com', 'password'=>'password']
			),
			array(
				['name'=>'name1003', 'email'=>'email1003@mail.com', 'password'=>'password']
			)
		);
		return $array;
	}
	
	/**
	 * @dataProvider registerUserDataNoCorrectExceptionProvider
	 *
	 */
	public function testRegisterUserDataNoCorrectException(array $data)
	{
		
		$this->expectException(RegisterUserDataNotCorrectException::class);
		
		$result = $this->service->registerUser($data);
	}
	static function registerUserDataNoCorrectExceptionProvider(): array
	{
		$array = array(
			array(
				['name'=>'name1001', 'password'=>'password']
			),
			array(
				['name'=>'name1002', 'email'=>'email1002@mail.com']
			),
			array(
				[ 'email'=>'email1003@mail.com', 'password'=>'password']
			),
			array(
				[]
			),
			array(
				['password'=>'password']
			),
			array(
				['name'=>'name1002']
			),
			array(
				[ 'email'=>'email1003@mail.com']
			)
		);
		return $array;
	}

	public function testAddAdminRoleToUserSuccess()
	{
		$user = User::factory()->create();
		$result = $this->service->addAdminRoleToUser($user);
		$this->assertTrue($user->hasRole('admin'));
	}
	
	public function testAddPlayerRoleToUserSuccess()
	{
		$user = User::factory()->create();
		$result = $this->service->addPlayerRoleToUser($user);
		$this->assertTrue($user->hasRole('player'));
	}
	
	public function testRemoveAdminRoleToUserSuccess()
	{
		$user = User::factory()->create();
		$user->assignRole('admin');
		$result = $this->service->removeAdminRoleToUser($user);
		$this->assertFalse($user->hasRole('admin'));
	}
	
	public function testRemovePlayerRoleToUserSuccess()
	{
		$user = User::factory()->create();
		$user->assignRole('player');
		$result = $this->service->removePlayerRoleToUser($user);
		$this->assertFalse($user->hasRole('player'));
	}
	
	
	
	
	
	
	public function testCreateJWTokenSuccess()
	{
		$user = User::factory()->create();
		
		$jwt = $this->service->createJWTokenByUser($user);
		
		$resultOne = preg_match('(^[\w-]*\.[\w-]*\.[\w-]*$)', $jwt);
		$resultTwo = preg_match('(^[A-Za-z0-9-_]*\.[A-Za-z0-9-_]*\.[A-Za-z0-9-_]*$)', $jwt);

		$this->assertEquals($resultOne, true);
		$this->assertEquals($resultTwo, true);
		
	}
	
	/*
	//ToDo - Make Passport do not produce a token somehow, cannot mock the model in laravel
	//I think to remember that passport need not null in email at least [Note]
	public function testCreateJWTokenException()
	{
		// Temporarily disable foreign key checks
        //DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		//$user = User::factory()->create(['id'=>null, 'name'=>null,'email'=>null,'password'=>null]);
		$user = User::factory()->create(['email'=>null]);

		//$this->expectException(JWTokenNotGeneratedException::class);
		
		$jwt = $this->service->createJWTokenByUser($user);
		
		//DB::statement('SET FOREIGN_KEY_CHECKS=1;');
		
		$resultOne = preg_match('(^[\w-]*\.[\w-]*\.[\w-]*$)', $jwt);
		$resultTwo = preg_match('(^[A-Za-z0-9-_]*\.[A-Za-z0-9-_]*\.[A-Za-z0-9-_]*$)', $jwt);
		echo $jwt;
		echo $user->email;

		$this->assertEquals($resultOne, true);
		$this->assertEquals($resultTwo, true);
	}
	*/
	public function testUpdateNameSuccess()
	{
		$user = User::factory()->create(['name'=>'oldName']);
		$user_new = $this->service->updateUserName($user, 'newName');
		$this->assertEquals('newName', $user_new->name);
		$this->assertEquals('newName', $user->name);
	}
		
	protected function tearDown(): void
	{
		parent::tearDown();
		Mockery::close(); 
	}
}
