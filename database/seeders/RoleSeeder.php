<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['admin', 'organizer', 'user'];

        foreach ($roles as $index => $role) {
            Role::create([
                'idrole' => $index + 1,
                'nama_role' => $role
            ]);
        }
    }
}