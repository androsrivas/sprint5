<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->call(RoleSeeder::class);
        
        User::create([
            'name' => NULL,
            'nickname' => 'admin',
            'email' => 'admin@example.com', 
            'password' => bcrypt('admin123'),
        ]);

        User::factory(9)->create();
        // Ranking::factory(100)->create();

        $this->call(GameSeeder::class);
    }
}
