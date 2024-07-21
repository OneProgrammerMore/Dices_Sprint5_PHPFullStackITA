<?php
declare(strict_types=1);

namespace Tests\Feature\Controller\Student;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Testing\TestResponse;

use Laravel\Passport\Passport;
use Mockery;

use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\Throws;

class GameControllerTest extends TestCase
{
	use DatabaseTransactions;
	
	protected function setUp(): void
    {
        parent::setUp();
    }
	
	
	// Route POST- /api/players/{user}/games
	//GameController::class . '@store'
	public function test_game_store_success(): void
	{
		$user = User::factory()->create();
		$user->assignRole('player');
				
		//Authentuication for Passport
		Passport::actingAs(
			$user
		);     
          
        // Ensure the user is considered to have the 'player' role
        $this->assertTrue($user->hasRole('player'));
		
		$response = $this->json('POST', '/api/players/' . $user->id . '/games');
		
		$response->assertStatus(201);
		$response->assertJsonStructure([
				'user_id',
                'dice_1',
                'dice_2',
				'dices_sum'
             ]);
		
	}
	

	public function test_game_store_middleware_user_not_found(): void
	{
		$user = User::factory()->create();
		$user->assignRole('player');
				
		//Authentuication for Passport
		Passport::actingAs(
			$user
		);     
          
        // Ensure the user is considered to have the 'player' role
        $this->assertTrue($user->hasRole('player'));
		
		$user_2 = User::factory()->create();
		$user_2_id = $user_2->id;
		$user_2->delete();
		
		$response = $this->json('POST', '/api/players/' . $user_2_id . '/games');
		
		$response->assertStatus(404);

	}
	
	
	// Route DELETE - /api/players/{player}/games
	public function test_game_destroy_success(): void
	{
		$user = User::factory()->create();
		$game = Throws::factory()->create(['user_id'=>$user->id]);
		$user->assignRole('player');
				
		//Authentuication for Passport
		Passport::actingAs(
			$user
		);     
          
        // Ensure the user is considered to have the 'player' role
        $this->assertTrue($user->hasRole('player'));
		
		$response = $this->json('DELETE', '/api/players/' . $user->id . '/games');
		
		$response->assertStatus(201);
	}

	public function test_game_destroy_user_not_found(): void
	{
		$user = User::factory()->create();
		$game = Throws::factory()->create(['user_id'=>$user->id]);
		$user->assignRole('player');
		$user_2 = User::factory()->create();
		$user_2_id = $user_2->id;
		$user_2->delete();
		
		//Authentuication for Passport
		Passport::actingAs(
			$user
		);     
          
        // Ensure the user is considered to have the 'player' role
        $this->assertTrue($user->hasRole('player'));
		
		$response = $this->json('DELETE', '/api/players/' . $user_2_id . '/games');
		
		$response->assertStatus(404);
	}
	
	
	// Route GET - /api/players/{player}/games
	public function test_game_read_success_player(): void
	{
		$user = User::factory()->create();
		$game = Throws::factory()->create(['user_id'=>$user->id]);
		$user->assignRole('player');
				
		//Authentuication for Passport
		Passport::actingAs(
			$user
		);     
          
        // Ensure the user is considered to have the 'player' role
        $this->assertTrue($user->hasRole('player'));
		
		$response = $this->json('GET', '/api/players/' . $user->id . '/games');
		
		$response->assertStatus(200);
	}
	
	public function test_game_read_success_admin(): void
	{
		$user = User::factory()->create();
		$game = Throws::factory()->create(['user_id'=>$user->id]);
		$user->assignRole('admin');
				
		//Authentuication for Passport
		Passport::actingAs(
			$user
		);     
          
        // Ensure the user is considered to have the 'player' role
        $this->assertTrue($user->hasRole('admin'));
		
		$response = $this->json('GET', '/api/players/' . $user->id . '/games');
		
		$response->assertStatus(200);
	}

	public function test_game_read_success_player_user_not_found(): void
	{
		$user = User::factory()->create();
		$game = Throws::factory()->create(['user_id'=>$user->id]);
		$user->assignRole('player');
		
		$user_2 = User::factory()->create();
		$user_2_id = $user_2->id;
		$user_2->delete();
				
		//Authentuication for Passport
		Passport::actingAs(
			$user
		);     
          
        // Ensure the user is considered to have the 'player' role
        $this->assertTrue($user->hasRole('player'));
		
		$response = $this->json('GET', '/api/players/' . $user_2_id . '/games');
		
		$response->assertStatus(404);
	}
	
	public function test_game_read_success_admin_user_not_found(): void
	{
		$user = User::factory()->create();
		$game = Throws::factory()->create(['user_id'=>$user->id]);
		$user->assignRole('admin');
		
		$user_2 = User::factory()->create();
		$user_2_id = $user_2->id;
		$user_2->delete();
				
		//Authentuication for Passport
		Passport::actingAs(
			$user
		);     
          
        // Ensure the user is considered to have the 'player' role
        $this->assertTrue($user->hasRole('admin'));
		
		$response = $this->json('GET', '/api/players/' . $user_2_id . '/games');
		
		$response->assertStatus(404);
	}
	
	
	
}
