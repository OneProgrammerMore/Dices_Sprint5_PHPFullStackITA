<?php
declare(strict_types=1);

namespace Tests\Feature\Service;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\User;
use App\Models\Throws;

use App\Service\PlayerService;

use App\Exceptions\ThrowNotStoredInDBException;
use App\Exceptions\NoGamesStoredForUserInDBException;
use App\Exceptions\NoGamesStoredInDBException;

class PlayerServiceTest extends TestCase
{
	use DatabaseTransactions;
	private $service;

	public function setUp(): void
	{
		parent::setUp();
		$this->service = new PlayerService();
	}


	public function testGetRankingSuccess(): void
	{
		$users_amount = 7; 
		
		$user = User::factory($users_amount)->create();
		$throws = Throws::factory(200)->create();
		
		$result = $this->service->getRanking();
		
		//dd($result);	
		$this->assertEquals($users_amount, count($result));
		$i = 0;
		foreach($result as $item_i){	
			$x = 0;
			foreach($result as $item_x){
					if($i<$x){
						$this->assertTrue($item_i['wins_perc'] >= $item_x['wins_perc']);
					}
				$x++;
			} 
			$i++;
		} 
	}
	
	public function testGetRankingExcepiton(): void
	{
		$this->expectException(NoGamesStoredInDBException::class);
		
		$result = $this->service->getRanking();
	}

	
	public function testGetListAllUserWithWinsPercentageSuccess():void
	{
		$users_amount = 7; 
		
		$user = User::factory($users_amount)->create();
		$throws = Throws::factory(200)->create();
		
		$result = $this->service->getListAllUserWithWinsPercentage();
		
		//dd($result);	
		$this->assertEquals($users_amount, count($result));
	}
	
	public function testGetListAllUserWithWinsPercentageExcepiton(): void
	{
		$this->expectException(NoGamesStoredInDBException::class);
		
		$result = $this->service->getListAllUserWithWinsPercentage();
	}
	
	
	public function testGetWorstFromRankingSuccess(): void
	{
		$users_amount = 7; 
		
		$user = User::factory($users_amount)->create();
		$throws = Throws::factory(200)->create();
		
		$ranking = $this->service->getRanking();
		
		$result = $this->service->getWorstFromRanking($ranking);
		
		
		
		$this->assertEquals($ranking[count($ranking)-1], $result);
	}
	
	public function testGetWorstFromRankingException(): void
	{

		$this->expectException(NoGamesStoredInDBException::class);
		
		$result = $this->service->getWorstFromRanking([]);
		
	}
	
	public function testGetBestFromRankingSuccess(): void
	{
		$users_amount = 7; 
		
		$user = User::factory($users_amount)->create();
		$throws = Throws::factory(200)->create();
		
		$ranking = $this->service->getRanking();
		
		$result = $this->service->getBestFromRanking($ranking);
		
		
		
		$this->assertEquals($ranking[0], $result);
	}
	
	public function testGetBestFromRankingException(): void
	{

		$this->expectException(NoGamesStoredInDBException::class);
		
		$result = $this->service->getBestFromRanking([]);
		
	}
	
	
	
	protected function tearDown(): void
	{
		parent::tearDown();
	}
}
