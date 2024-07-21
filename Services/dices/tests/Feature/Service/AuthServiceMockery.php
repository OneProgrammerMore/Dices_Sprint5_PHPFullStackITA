<?php
declare(strict_types=1);

namespace Tests\Feature\Controller\User;

use Tests\TestCase;
use Mockery;
use Illuminate\Support\Str;
use Laravel\Passport\Passport;
use Laravel\Passport\PersonalAccessTokenResult;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;
use App\Exceptions\JWTokenNotGeneratedException;

use App\Service\AuthService;


//This tests is let here in order to know how to mock models in the app
/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
//class AuthServiceMockeryTest extends TestCase
class AuthServiceMockery extends TestCase
{	
	use DatabaseTransactions;
	
	private $service;
	
	public function setUp(): void
	{
		parent::setUp();
		$this->service = new AuthService();
	}
	
	//OMG how hard it is to mock passport....
	
	public function testCreateJWTokenException(){
		
        $returnUser = User::factory()->create();

        $userMock = Mockery::mock($returnUser)->makePartial();

		$object = new \stdClass();
		$object->accessToken = '';
        $userMock->shouldReceive('createToken')
                 ->once()
                 ->andReturn($object);
		$this->app->instance('overload:App\Models\User', $userMock);


		$this->expectException(JWTokenNotGeneratedException::class);
		
		$jwt = $this->service->createJWTokenByUser($userMock);
	
	}
	
	protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close(); // Clean up Mockery
    }
	
}

