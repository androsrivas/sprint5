<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'admin']);
        $player = Role::create(['name' => 'player']);

        //admin routes
        Permission::create(['name' => 'admin.players'])->assignRole($admin);
        Permission::create(['name' => 'admin.ranking'])->assignRole($admin);
        Permission::create(['name' => 'admin.ranking.winner'])->assignRole('admin');
        Permission::create(['name' => 'admin.ranking.loser'])->assignRole('admin');
        Permission::create(['name' => 'admin.player.delete'])->assignRole($admin);

        //players routes
        Permission::create(['name' => 'players.update'])->assignRole($player);
        Permission::create(['name' => 'players.games.delete'])->assignRole($player);
        
        //admin and players routes
        Permission::create(['name' => 'users.login'])->syncRoles($admin, $player);
        Permission::create(['name' => 'players.games'])->syncRoles($admin, $player);
        Permission::create(['name' => 'players.games.newGame'])->syncRoles($admin, $player);
        
        
    }
}
