<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SuperAdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_super_admin_cannot_access_admin_management_routes()
    {
        $admin = Admin::factory()->create([
            'super_admin' => false,
        ]);

        $this->actingAs($admin, 'admin')
            ->get(route('dashboard.admins.index'))
            ->assertForbidden();

        $this->actingAs($admin, 'admin')
            ->get(route('dashboard.roles.index'))
            ->assertForbidden();
    }

    public function test_super_admin_can_access_admin_management_routes()
    {
        $admin = Admin::factory()->create([
            'super_admin' => true,
        ]);

        $this->actingAs($admin, 'admin')
            ->get(route('dashboard.admins.index'))
            ->assertOk();

        $this->actingAs($admin, 'admin')
            ->get(route('dashboard.roles.index'))
            ->assertOk();
    }
}
