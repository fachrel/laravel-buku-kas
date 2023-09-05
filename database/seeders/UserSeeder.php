<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'username' => 'admin',
            'name' => 'admin',
            'password' => '$2y$10$qAkhcsLfDIJAeQu47hi3HOXWGfvewg2sZWlRM8p5.qbUi4lCkomFW',
        ]);
        $admin->assignRole('admin');

        $user1 = User::create([
            'username' => 'user',
            'name' => 'Fachrel Razka Pramudya',
            'password' => '$2y$10$uYHptDEjbBgqINTH/LHgwumH.eGE4WgSPBXXEO8IeEYANBNmGX7i6',
        ]);
        $user1->assignRole('user');

        $user2 = User::create([
            'username' => 'michie',
            'name' => 'Michelle Alexandra',
            'password' => '$2y$10$i3HaWIKf2KITVy2ExoE7XuN/pxQavSWMHVNNi6RYuWWJ4NEVFrMK.',
        ]);
        $user2->assignRole('user');
    }
}
