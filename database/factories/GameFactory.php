<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dice1 = fake()->randomNumber(1, 6);
        $dice2 = fake()->randomNumber(1, 6);

        return [
            'dice_1' => $dice1,
            'dice_2' => $dice2,
            'result' => $dice1 + $dice2,
            'user_id' => User::inRandomOrder()->value('id'),
        ];
    }
}
