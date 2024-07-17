<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $ownerRole = Role::create(['name' => 'owner']);

        $fundraiserRole = Role::create(['name' => 'fundraiser']);

        $userowner = User::create([
            'name' => 'Adrian Ramadhan',
            'avatar' => 'images/default-avatar.jpg',
            'email' => 'adrian@owner.com',
            'password' => bcrypt('password')
        ]);

        $userfundraising = User::create([
            'name' => 'Adrian Ramadhan',
            'avatar' => 'images/default-avatar.jpg',
            'email' => 'adrian@fundraiser.com',
            'password' => bcrypt('password')
        ]);

        $userowner->assignRole($ownerRole);
        $userfundraising->assignRole($fundraiserRole);
    }
}
