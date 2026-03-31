<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'name' => 'client',
                'abilities' => [
                    'projects.create',
                    'projects.update',
                    'projects.delete',
                    'projects.view-own',
                ],
            ],
            [
                'name' => 'freelancer',
                'abilities' => [
                    'projects.browse',
                    'proposals.create',
                    'proposals.view-own',
                    'profile.update',
                ],
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['name' => $role['name']],
                ['abilities' => $role['abilities']]
            );
        }
    }
}
