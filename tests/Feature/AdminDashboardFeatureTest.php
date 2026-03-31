<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Project;
use App\Models\Proposal;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_pages_can_be_opened()
    {
        $admin = Admin::factory()->create();
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Development',
            'slug' => 'development',
        ]);

        $project = Project::withoutGlobalScope('active')->create([
            'title' => 'Admin review project',
            'desc' => 'Review this project from dashboard.',
            'category_id' => $category->id,
            'user_id' => $user->id,
            'status' => 'closed',
            'type' => 'fixed',
            'budget' => 1000,
        ]);

        $this->actingAs($admin, 'admin')->get(route('dashboard.dashboard'))->assertOk();
        $this->actingAs($admin, 'admin')->get(route('dashboard.projects.index'))->assertOk()->assertSee('Admin review project');
        $this->actingAs($admin, 'admin')->get(route('dashboard.projects.show', $project))->assertOk()->assertSee('Manage Project');
        $this->actingAs($admin, 'admin')->get(route('dashboard.users.index'))->assertOk()->assertSee($user->email);
        $this->actingAs($admin, 'admin')->get(route('dashboard.admins.index'))->assertOk()->assertSee($admin->email);
    }

    public function test_admin_can_update_user_roles_and_project_status()
    {
        $admin = Admin::factory()->create();
        $user = User::factory()->create();
        $role = Role::create([
            'name' => 'Manager',
            'abilities' => ['users.view'],
        ]);
        $category = Category::create([
            'name' => 'Design',
            'slug' => 'design',
        ]);

        $project = Project::withoutGlobalScope('active')->create([
            'title' => 'Dashboard project',
            'desc' => 'Dashboard managed project.',
            'category_id' => $category->id,
            'user_id' => $user->id,
            'status' => 'open',
            'type' => 'fixed',
            'budget' => 700,
        ]);

        $this->actingAs($admin, 'admin')
            ->put(route('dashboard.users.update', $user), [
                'name' => 'Updated User',
                'email' => $user->email,
                'roles' => [$role->id],
            ])
            ->assertRedirect(route('dashboard.users.index'));

        $this->assertDatabaseHas('role_user', [
            'user_id' => $user->id,
            'role_id' => $role->id,
        ]);

        $this->actingAs($admin, 'admin')
            ->put(route('dashboard.projects.update', $project), [
                'title' => 'Dashboard project',
                'desc' => 'Dashboard managed project.',
                'category_id' => $category->id,
                'status' => 'closed',
                'type' => 'fixed',
                'budget' => 700,
            ])
            ->assertRedirect(route('dashboard.projects.show', $project));

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'status' => 'closed',
        ]);
    }

    public function test_inactive_admin_cannot_log_in_or_access_dashboard()
    {
        $password = 'password123';

        $inactiveAdmin = Admin::create([
            'name' => 'Inactive Admin',
            'email' => 'inactive-admin@example.com',
            'password' => Hash::make($password),
            'status' => 'inactive',
            'super_admin' => false,
        ]);

        $this->post(route('admin.login'), [
            'email' => $inactiveAdmin->email,
            'password' => $password,
        ])->assertSessionHasErrors('email');

        $this->actingAs($inactiveAdmin, 'admin')
            ->get(route('dashboard.dashboard'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_run_bulk_actions_for_projects_proposals_and_users()
    {
        $admin = Admin::factory()->create();
        $client = User::factory()->create();
        $freelancer = User::factory()->create();
        $extraUser = User::factory()->create();
        $category = Category::create([
            'name' => 'Operations',
            'slug' => 'operations',
        ]);

        $project = Project::withoutGlobalScope('active')->create([
            'title' => 'Bulk target project',
            'desc' => 'Bulk operations test.',
            'category_id' => $category->id,
            'user_id' => $client->id,
            'status' => 'open',
            'type' => 'fixed',
            'budget' => 500,
        ]);

        $proposal = Proposal::create([
            'freelancer_id' => $freelancer->id,
            'project_id' => $project->id,
            'description' => 'Bulk target proposal',
            'cost' => 450,
            'duration' => 5,
            'duration_unit' => 'day',
            'status' => 'pending',
        ]);

        $this->actingAs($admin, 'admin')
            ->post(route('dashboard.projects.bulk'), [
                'project_ids' => [$project->id],
                'action' => 'closed',
            ])
            ->assertRedirect(route('dashboard.projects.index'));

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'status' => 'closed',
        ]);

        $this->actingAs($admin, 'admin')
            ->post(route('dashboard.proposals.bulk'), [
                'proposal_ids' => [$proposal->id],
                'action' => 'accepted',
            ])
            ->assertRedirect(route('dashboard.proposals.index'));

        $this->assertDatabaseHas('proposals', [
            'id' => $proposal->id,
            'status' => 'accepted',
        ]);

        $this->actingAs($admin, 'admin')
            ->post(route('dashboard.users.bulk'), [
                'user_ids' => [$extraUser->id],
                'action' => 'delete',
            ])
            ->assertRedirect(route('dashboard.users.index'));

        $this->assertDatabaseMissing('users', [
            'id' => $extraUser->id,
        ]);
    }
}
