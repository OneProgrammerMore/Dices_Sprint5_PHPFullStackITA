<?php
declare(strict_types=1);

namespace Tests\Feature\Controller\User;

use Tests\TestCase;
use App\Models\User;

use Mockery;
//use Illuminate\Foundation\Testing\DatabaseTransactions;


/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class AuthServiceMockeryTest extends TestCase
{	
	//use DatabaseTransactions;
	
	private $mockery;
	
	public function setUp(): void
	{
		parent::setUp();
		$this->mockery = Mockery::mock('overload:App\Models\User');
	}
	
	
	public function testCreateJWTokenException(){
		
		$user = User::factory()->make();

		$this->expectException(JWTokenNotGeneratedException::class);
		
		$this->mockery->shouldReceive('createToken')
			->once()
			->andReturn(null);
			
		$this->app->instance('overload:App\Models\User', $this->mockery);	
		
		$jwt = $this->service->createJWTokenByUser($user);
	
	}
	
	protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close(); // Clean up Mockery
    }
	
}

