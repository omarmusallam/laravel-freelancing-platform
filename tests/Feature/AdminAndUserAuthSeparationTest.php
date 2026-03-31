<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\User;
use Tests\TestCase;

class AdminAndUserAuthSeparationTest extends TestCase
{
    public function test_admin_can_still_open_user_login_page()
    {
        $admin = new Admin([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password',
            'super_admin' => true,
            'status' => 'active',
        ]);

        $response = $this->actingAs($admin, 'admin')->get('/login');

        $response->assertOk();
    }

    public function test_user_can_still_open_admin_login_page()
    {
        $user = new User([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => 'password',
        ]);

        $response = $this->actingAs($user, 'web')->get('/admin/login');

        $response->assertOk();
    }

    public function test_authenticated_admin_is_redirected_to_dashboard_when_visiting_admin_login()
    {
        $admin = new Admin([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password',
            'super_admin' => true,
            'status' => 'active',
        ]);

        $response = $this->actingAs($admin, 'admin')->get('/admin/login');

        $response->assertRedirect(route('dashboard.dashboard'));
    }
}
