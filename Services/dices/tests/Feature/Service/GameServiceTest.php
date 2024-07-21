<?php
declare(strict_types=1);

namespace Tests\Feature\Service;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

use App\Models\User;
use App\Models\Throws;

use App\Service\GameService;

use App\Exceptions\ThrowNotStoredInDBException;
use App\Exceptions\NoGamesStoredForUserInDBException;
use Illuminate\Database\QueryException;

class GameServiceTest extends TestCase
{
	use DatabaseTransactions;
	private $service;

	public function setUp(): void
	{
		parent::setUp();
		$this->service = new GameService();
	}

	public function testThrowDicesSuccess(): void
	{
		for ($i = 1; $i <= 20; $i++) {
			$result = $this->service->throwDices();
			
			// Assert that the result is an array.
			$this->assertIsArray($result, 'The result is not an array');

			// Assert that the array has exactly two elements.
			$this->assertCount(2, $result, 'The array does not contain exactly two elements');

			// Assert that both values are integers within the range of 1 to 6.
			foreach ($result as $value) {
				$this->assertIsInt($value, 'The value is not an integer');
				$this->assertGreaterThanOrEqual(1, $value, 'The value is less than 1');
				$this->assertLessThanOrEqual(6, $value, 'The value is greater than 6');
			}
		}
	}
	
	
	/**
	 * @dataProvider storeDicesInDBByUserSuccessProvider
	 *
	 */
	public function testStoreDicesInDBByUserSuccess(int $dice_1, int $dice_2): void
	{
		
		$user = User::factory()->create();
		
		$throw = ['dice_1' => $dice_1 , 'dice_2'=>$dice_2];
		
		$result = $this->service->storeDicesInDBByUser($user, $throw);
		
		$this->assertEquals($user->id, $result->user_id);
		$this->assertEquals($dice_1, $result->dice_1);
		$this->assertEquals($dice_2, $result->dice_2);
		$this->assertEquals($dice_1 + $dice_2, $result->dices_sum);
	
	}
	
	static function storeDicesInDBByUserSuccessProvider(): array
	{
		$array = array(
			array(
				1 , 6
			),
			array(
				1 , 4
			),
			array(
				2 , 6
			)
		);
		return $array;
	}
	
	
	/**
	 * @dataProvider storeDicesInDBByUserExceptionProvider
	 *
	 */
	public function testStoreDicesInDBByUserException(int | null | string | bool $dice_1, int | null | string | bool $dice_2): void
	{
		
		$user = User::factory()->create();
		
		$throw = ['dice_1' => $dice_1 , 'dice_2'=>$dice_2];
		
		$this->expectException(QueryException::class);
		
		$result = $this->service->storeDicesInDBByUser($user, $throw);
		
	}
	
	static function storeDicesInDBByUserExceptionProvider(): array
	{
		$array = array(
			array(
				1 , null
			),
			array(
				1 , 'blabla'
			),
			array(
				2 , false
			)
		);
		return $array;
	}
	
	
	
	public function testReturnGamesPlayedByUserSuccess()
	{
		$users = User::factory(5)->create();
		$throws = Throws::factory(100)->create();
		
		$user = $throws->random()->user;
		
		$result = $this->service->returnGamesPlayedByUser($user);

		$this->assertEquals(true, $result->count() > 0);
		// Assert that all models in the collection have the property set to the expected value
        $result->each(function ($model) use ($user) {
            $this->assertEquals($user->id, $model->user_id);
        });
	}
	
	public function testReturnGamesPlayedByUserException()
	{
		$users = User::factory(5)->create();
		$throws = Throws::factory(100)->create();
		
		$user = $throws->random()->user;
		$user_error = $user;
		$user->delete();
		
		$this->expectException(NoGamesStoredForUserInDBException::class);
		$result = $this->service->returnGamesPlayedByUser($user_error);
		
	}
	
	
	public function testDeleteGamesPlayedByUserSuccess()
	{
		$users = User::factory(5)->create();
		$throws = Throws::factory(100)->create();
		
		$user = $throws->random()->user;
		
		$result = $this->service->deleteGamesPlayedByUser($user);

		$this->assertEquals(true, $result);

	}
	

	
	
	
	
	protected function tearDown(): void
	{
		parent::tearDown();
	}
}
