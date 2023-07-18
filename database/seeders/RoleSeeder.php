<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'admin', 'guard_name' => 'api']);
        $player = Role::create(['name' => 'player', 'guard_name' => 'api']);

        //admin permissions
        Permission::create(['name' => 'admin.players', 'guard_name' => 'api'])->assignRole($admin);
        Permission::create(['name' => 'admin.ranking', 'guard_name' => 'api'])->assignRole($admin);
        Permission::create(['name' => 'admin.ranking.winner', 'guard_name' => 'api'])->assignRole($admin);
        Permission::create(['name' => 'admin.ranking.loser', 'guard_name' => 'api'])->assignRole($admin);
        Permission::create(['name' => 'admin.player.delete', 'guard_name' => 'api'])->assignRole($admin);

        //players permissions
        Permission::create(['name' => 'players.update', 'guard_name' => 'api'])->assignRole($player);
        Permission::create(['name' => 'players.games.delete', 'guard_name' => 'api'])->assignRole($player);
        
        //admin and players permissions
        Permission::create(['name' => 'players.games', 'guard_name' => 'api'])->syncRoles($admin, $player);
        Permission::create(['name' => 'players.games.newGame', 'guard_name' => 'api'])->syncRoles($admin, $player);

        //user with admin role
        User::create([
            'email' => 'admin@example.com', 
            'nickname' => 'admin',
            'email_verified_at' => now(),
            'password' => bcrypt('admin123'),
            'remember_token' => Str::random(10),
        ])->assignRole('admin');
    }
}
