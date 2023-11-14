<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function test_admin_retrieves_all_users()
    {
        $user = User::factory()->create()->assignRole('admin');
        Passport::actingAs($user);

        $response = $this->getJson(route('admin.players'))->assertOk();
    }

    public function test_player_cant_retrieve_all_users()
    {
        $user = User::factory()->create()->assignRole('player');
        Passport::actingAs($user);

        $response = $this->getJson(route('admin.players'))->assertStatus(403);
    }

    public function test_player_can_update_own_info()
    {
        $user = User::factory()->create()->assignRole('player');
        Passport::actingAs($user);

        $response = $this->putJson(route('players.update', $user->id), [
            'email' => fake()->unique()->email(),
            'password' => 'password',
            'nickname' => fake()->unique()->userName(),
        ])->assertOk();
    }

    public function test_player_cant_update_other_players_info()
    {
        $user = User::factory()->create()->assignRole('player');
        Passport::actingAs($user);

        $response = $this->putJson(route('players.update', $user->id - 1), [
            'nickname' => 'new_nickname',
        ]);

        $response->assertJsonStructure([
            'message',
        ])->assertStatus(401);
    }

    public function test_player_cant_update_nickname_with_existing_nickname()
    {
        $user = User::factory()->create()->assignRole('player');
        Passport::actingAs($user);

        $user->nickname = 'anonymous-234';

        $response = $this->putJson(route('players.update', $user->id), [
            'nickname' => 'ddddust',
        ]);

        $response->assertJsonStructure([
            'message',
        ])->assertStatus(422);

    }

    public function test_admin_can_delete_user()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $userToDelete = User::factory()->create()->assignRole('player');
        Passport::actingAs($admin);

        $response = $this->deleteJson(route('admin.player.delete', ['player' => $userToDelete->id]));

        $response->assertOk();

        $this->assertDatabaseMissing('users', ['id' => $userToDelete->id]);
    }

    public function test_player_cannot_delete_another_player()
    {
        $player1 = User::factory()->create()->assignRole('player');
        $player2 = User::factory()->create()->assignRole('player');
        Passport::actingAs($player1);

        $response = $this->deleteJson(route('admin.player.delete', ['player' => $player2->id]));

        $response->assertStatus(403);
    }
}
