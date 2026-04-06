<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Contract;
use App\Models\Message;
use App\Models\Payment;
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
        $admin = Admin::factory()->create([
            'super_admin' => true,
        ]);
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
        $admin = Admin::factory()->create([
            'super_admin' => true,
        ]);
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

        $otherProposal = Proposal::create([
            'freelancer_id' => $extraUser->id,
            'project_id' => $project->id,
            'description' => 'Secondary proposal',
            'cost' => 480,
            'duration' => 6,
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
        $this->assertDatabaseHas('proposals', [
            'id' => $otherProposal->id,
            'status' => 'declined',
        ]);
        $this->assertDatabaseHas('contracts', [
            'proposal_id' => $proposal->id,
            'project_id' => $project->id,
            'status' => 'active',
        ]);
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'status' => 'closed',
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

    public function test_admin_can_review_and_manage_contracts_payments_and_messages()
    {
        $admin = Admin::factory()->create([
            'super_admin' => true,
        ]);
        $client = User::factory()->create([
            'name' => 'Client Owner',
            'email' => 'client-owner@example.com',
        ]);
        $freelancer = User::factory()->create([
            'name' => 'Freelancer Pro',
            'email' => 'freelancer-pro@example.com',
        ]);
        $category = Category::create([
            'name' => 'Writing',
            'slug' => 'writing',
        ]);
        $clientRole = Role::create([
            'name' => 'client',
            'abilities' => ['projects.create'],
        ]);
        $freelancerRole = Role::create([
            'name' => 'freelancer',
            'abilities' => ['proposals.create'],
        ]);
        $client->roles()->attach($clientRole);
        $freelancer->roles()->attach($freelancerRole);

        $project = Project::withoutGlobalScope('active')->create([
            'title' => 'Content Strategy Project',
            'desc' => 'Create a premium content strategy for a SaaS company.',
            'category_id' => $category->id,
            'user_id' => $client->id,
            'status' => 'in-progress',
            'type' => 'fixed',
            'budget' => 1500,
        ]);

        $proposal = Proposal::create([
            'freelancer_id' => $freelancer->id,
            'project_id' => $project->id,
            'description' => 'I can deliver the strategy and editorial calendar.',
            'cost' => 1400,
            'duration' => 14,
            'duration_unit' => 'day',
            'status' => 'accepted',
        ]);

        $contract = Contract::create([
            'proposal_id' => $proposal->id,
            'freelancer_id' => $freelancer->id,
            'project_id' => $project->id,
            'cost' => 1400,
            'type' => 'fixed',
            'start_on' => now()->subDays(2)->toDateString(),
            'end_on' => now()->addDays(12)->toDateString(),
            'status' => 'active',
        ]);

        $payment = Payment::create([
            'user_id' => $client->id,
            'gateway' => 'paypal',
            'reference_id' => 'PAY-001',
            'status' => 'pending',
            'amount' => 1400,
            'data' => ['invoice' => 'INV-001'],
        ]);

        $message = Message::create([
            'sender_id' => $client->id,
            'recipient_id' => $freelancer->id,
            'message' => 'Please share the final weekly content roadmap today.',
        ]);

        $this->actingAs($admin, 'admin')
            ->get(route('dashboard.dashboard'))
            ->assertOk()
            ->assertSee('Operations Overview')
            ->assertSee('Operational Alerts')
            ->assertSee('Marketplace Health')
            ->assertSee('Action Queue')
            ->assertSee('Live Activity Feed')
            ->assertSee('Recent Contracts')
            ->assertSee('Recent Payments')
            ->assertSee('Recent Messages');

        $this->actingAs($admin, 'admin')
            ->get(route('dashboard.contracts.index'))
            ->assertOk()
            ->assertSee('Content Strategy Project')
            ->assertSee('Active Contracts');

        $this->actingAs($admin, 'admin')
            ->get(route('dashboard.contracts.index', ['q' => 'Client Owner', 'status' => 'active']))
            ->assertOk()
            ->assertSee('Content Strategy Project');

        $this->actingAs($admin, 'admin')
            ->get(route('dashboard.contracts.show', $contract))
            ->assertOk()
            ->assertSee('Manage Contract')
            ->assertSee('Client Owner')
            ->assertSee('Contract Control Panel');

        $this->actingAs($admin, 'admin')
            ->put(route('dashboard.contracts.update', $contract), [
                'status' => 'completed',
                'cost' => 1500,
                'hours' => 42,
                'start_on' => now()->subDays(2)->toDateString(),
                'end_on' => now()->addDays(10)->toDateString(),
                'completed_on' => now()->toDateString(),
            ])
            ->assertRedirect(route('dashboard.contracts.show', $contract));

        $this->assertDatabaseHas('contracts', [
            'id' => $contract->id,
            'status' => 'completed',
            'cost' => 1500,
        ]);
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'status' => 'closed',
        ]);
        $this->assertDatabaseHas('proposals', [
            'id' => $proposal->id,
            'status' => 'accepted',
        ]);

        $this->actingAs($admin, 'admin')
            ->put(route('dashboard.contracts.update', $contract), [
                'status' => 'terminated',
                'cost' => 1500,
                'hours' => 42,
                'start_on' => now()->subDays(2)->toDateString(),
                'end_on' => now()->addDays(10)->toDateString(),
                'completed_on' => now()->toDateString(),
            ])
            ->assertRedirect(route('dashboard.contracts.show', $contract));

        $this->assertDatabaseHas('contracts', [
            'id' => $contract->id,
            'status' => 'terminated',
        ]);
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'status' => 'open',
        ]);
        $this->assertDatabaseHas('proposals', [
            'id' => $proposal->id,
            'status' => 'declined',
        ]);

        $this->actingAs($admin, 'admin')
            ->get(route('dashboard.projects.index', ['q' => 'client-owner@example.com', 'type' => 'fixed', 'status' => 'open']))
            ->assertOk()
            ->assertSee('Content Strategy Project')
            ->assertSee('Budget Volume');

        $this->actingAs($admin, 'admin')
            ->get(route('dashboard.payments.index', ['status' => 'pending']))
            ->assertOk()
            ->assertSee('PAY-001')
            ->assertSee('Pending Payments');

        $this->actingAs($admin, 'admin')
            ->get(route('dashboard.payments.index', ['q' => 'client-owner@example.com', 'gateway' => 'paypal']))
            ->assertOk()
            ->assertSee('PAY-001');

        $this->actingAs($admin, 'admin')
            ->get(route('dashboard.payments.show', $payment))
            ->assertOk()
            ->assertSee('Manage Payment')
            ->assertSee('INV-001')
            ->assertSee('Payment Review Desk');

        $this->actingAs($admin, 'admin')
            ->put(route('dashboard.payments.update', $payment), [
                'status' => 'success',
                'gateway' => 'paypal-business',
                'reference_id' => 'PAY-001-OK',
                'amount' => 1500,
            ])
            ->assertRedirect(route('dashboard.payments.show', $payment));

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'status' => 'success',
            'gateway' => 'paypal-business',
            'reference_id' => 'PAY-001-OK',
        ]);

        $this->actingAs($admin, 'admin')
            ->get(route('dashboard.messages.index', ['q' => 'weekly content roadmap']))
            ->assertOk()
            ->assertSee('weekly content roadmap')
            ->assertSee('Unread Messages');

        $this->actingAs($admin, 'admin')
            ->get(route('dashboard.proposals.index', ['q' => 'freelancer-pro@example.com', 'status' => 'declined']))
            ->assertOk()
            ->assertSee('Content Strategy Project')
            ->assertSee('Proposal Value');

        $this->actingAs($admin, 'admin')
            ->get(route('dashboard.users.index', ['q' => 'freelancer-pro@example.com', 'role' => 'freelancer']))
            ->assertOk()
            ->assertSee('Users With Contracts')
            ->assertSee('freelancer-pro@example.com');

        $this->actingAs($admin, 'admin')
            ->get(route('dashboard.messages.index', ['q' => 'client-owner@example.com', 'read' => 'unread']))
            ->assertOk()
            ->assertSee('Please share the final weekly content roadmap today.');

        $this->actingAs($admin, 'admin')
            ->get(route('dashboard.messages.show', $message))
            ->assertOk()
            ->assertSee('Message Review')
            ->assertSee('Client Owner')
            ->assertSee('Conversation Review');

        $this->assertDatabaseMissing('messages', [
            'id' => $message->id,
            'read_at' => null,
        ]);
    }
}
