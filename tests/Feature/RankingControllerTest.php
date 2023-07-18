<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RankingControllerTest extends TestCase
{
        public function test_admin_can_view_ranking()
        {
            $admin = User::factory()->create()->assignRole('admin');
            Passport::actingAs($admin);

            $response = $this->getJson(route('admin.ranking'));
            
            $response->assertOk();           

        }

        public function test_player_cannot_view_ranking()
        {
            $player = User::factory()->create()->assignRole('player');
            Passport::actingAs($player);

            $response = $this->getJson(route('admin.ranking'));

            $response->assertStatus(403);
        }

        public function test_admin_can_view_winner()
        {
            $admin = User::factory()->create()->assignRole('admin');
            Passport::actingAs($admin);

            $response = $this->getJson(route('admin.ranking.winner'));
            
            $response->assertOk();           

        }

        public function test_player_cannot_view_winner()
        {
            $player = User::factory()->create()->assignRole('player');
            Passport::actingAs($player);

            $response = $this->getJson(route('admin.ranking.winner'));

            $response->assertStatus(403);
        }

        public function test_admin_can_view_loser()
        {
            $admin = User::factory()->create()->assignRole('admin');
            Passport::actingAs($admin);

            $response = $this->getJson(route('admin.ranking.loser'));
            
            $response->assertOk();           

        }

        public function test_player_cannot_view_loser()
        {
            $player = User::factory()->create()->assignRole('player');
            Passport::actingAs($player);

            $response = $this->getJson(route('admin.ranking.loser'));

            $response->assertStatus(403);
        }
}
