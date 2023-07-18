<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GameControllerTest extends TestCase
{
    public function test_player_can_play_new_game()
    {
        $player = User::factory()->create()->assignRole('player');
        Passport::actingAs($player);

        $response = $this->postJson(route('players.newGame', $player->id));

        $response->assertStatus(201);
    }

    public function test_player_can_retrieve_own_games()
    {
        $player = User::factory()->create()->assignRole('player');
        Passport::actingAs($player);

        $response = $this->getJson(route('players.games', ['player' => $player->id]));

        $response->assertJsonStructure([
            'user',
            'win percentage',
            'games'
        ])->assertOk();
    }

    public function test_player_cannot_retrieve_another_players_games()
    {
        $player1 = User::factory()->create()->assignRole('player');
        $player2 = User::factory()->create()->assignRole('player');
        Passport::actingAs($player1);

        $response = $this->getJson(route('players.games', ['player' => $player2->id]));
        
        $response->assertStatus(403);
    }

    public function test_player_can_delete_all_own_games()
    {
        $player = User::factory()->create()->assignRole('player');
        Passport::actingAs($player);

        $response = $this->deleteJson(route('players.games', ['player' => $player->id]));

        $response->assertOk();
    }

    public function test_player_cannot_delete_other_players_games()
    {
        $player1 = User::factory()->create()->assignRole('player');
        $player2 = User::factory()->create()->assignRole('player');
        Passport::actingAs($player1);

        $response = $this->deleteJson(route('players.games', ['player' => $player2->id]));

        $response->assertStatus(403);

    }
}
