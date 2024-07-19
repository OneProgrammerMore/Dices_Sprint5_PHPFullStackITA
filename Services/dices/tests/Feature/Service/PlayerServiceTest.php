<?php
declare(strict_types=1);

namespace Tests\Feature\Service;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

use App\Models\User;
use App\Models\Throws;

use App\Service\PlayerService;

class PlayerServiceTest extends TestCase
{
	use DatabaseTransactions;
	private $service;

	public function setUp(): void
	{
		parent::setUp();
		$this->service = new PlayerService();
	}

	/**
	 * @dataProvider checkUserCredentialsSuccessProvider
	 *
	 */
	public function testCheckUserCredentialsSuccess(string $userDNI, string $password)
	{
		$user = User::factory()->create(['dni' => $userDNI, 'password' => bcrypt($password)]);

		$result = $this->service->checkUserCredentials($user, $password);

		$this->assertEquals(true, $result);
	}

	static function checkUserCredentialsSuccessProvider(): array
	{
		$array = array(
			array(
				'69818630Z',
				'password'
			),
			array(
				'X6849947H',
				'password'
			),
			array(
				'48332312C',
				'passOnePass'
			)
		);
		return $array;
	}


	protected function tearDown(): void
	{
		parent::tearDown();
	}
}
