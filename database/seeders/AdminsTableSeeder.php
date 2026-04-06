<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::updateOrCreate(
            ['email' => 'omar@gmail.com'],
            [
                'name' => 'Omar Musallam',
                'password' => Hash::make('password123'),
                'super_admin' => 1,
                'status' => 'active',
            ]
        );
    }
}
