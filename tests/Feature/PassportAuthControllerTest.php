<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PassportAuthControllerTest extends TestCase
{
    public function test_user_can_register()
    {
        $response = $this->postJson(route('users.register'), [
            'email' => fake()->unique()->email(),
            'password' => 'password',
            'nickname' => fake()->unique()->userName(),
        ]);
        
        $response->assertJsonStructure([
            'message',
            'user',
            'access_token',
            ])->assertOk();
                
    }

    public function test_user_cant_register_with_existing_email()
    {
        $response = $this->postJson(route('users.register'), [
            'email' => 'admin@example.com',
            'password' => 'admin123',
            'nickname' => 'test',
        ]);
        
        $response->assertStatus(400);
    }
    
    public function test_user_cant_register_with_existing_nickname()
    {
        $response = $this->postJson(route('users.register'), [
            'email' => fake()->unique()->email(),
            'password' => 'password',
            'nickname' => 'admin'
        ]);
        
        $response->assertStatus(400);
    }

    public function test_user_can_register_with_blank_nickname()
    {
        $response = $this->postJson(route('users.register'), [
            'email' => fake()->unique()->email(),
            'password' => 'password',
        ]);

        $response->assertJsonStructure([
            'message',
            'user',
            'access_token',
            ])->assertOk();
    }
    
    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson(route('users.login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);
        
        $response->assertJsonStructure([
            'message',
            'user',
            'token',
        ])->assertOk();
    }
    
    public function test_user_cant_login()
    {
        $user = User::factory()->create();
    
        $response = $this->postJson(route('users.login'), [
            'email' => $user->email,
            'password' => 'incorrect_password',
        ]);
    
        $response->assertJsonStructure([])->assertStatus(422);
    }

    public function test_user_can_logout()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $response = $this->postJson(route('users.logout'));

        $response->assertOk();
    }
}
