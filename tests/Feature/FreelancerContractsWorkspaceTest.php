<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Contract;
use App\Models\Payment;
use App\Models\Project;
use App\Models\Proposal;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FreelancerContractsWorkspaceTest extends TestCase
{
    use RefreshDatabase;

    public function test_freelancer_can_view_contracts_workspace_with_related_payments()
    {
        $client = User::factory()->create();
        $freelancer = User::factory()->create();

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

        $category = Category::create([
            'name' => 'Consulting',
            'slug' => 'consulting',
        ]);

        $project = Project::withoutGlobalScope('active')->create([
            'title' => 'Growth consulting sprint',
            'desc' => 'Support a growth execution sprint.',
            'category_id' => $category->id,
            'user_id' => $client->id,
            'status' => 'in-progress',
            'type' => 'fixed',
            'budget' => 2600,
        ]);

        $proposal = Proposal::create([
            'freelancer_id' => $freelancer->id,
            'project_id' => $project->id,
            'description' => 'Accepted proposal for growth sprint',
            'cost' => 2400,
            'duration' => 15,
            'duration_unit' => 'day',
            'status' => 'accepted',
        ]);

        $contract = Contract::create([
            'proposal_id' => $proposal->id,
            'freelancer_id' => $freelancer->id,
            'project_id' => $project->id,
            'cost' => 2400,
            'type' => 'fixed',
            'start_on' => now()->toDateString(),
            'end_on' => now()->addDays(15)->toDateString(),
            'status' => 'active',
        ]);

        Payment::create([
            'user_id' => $client->id,
            'gateway' => 'thawani',
            'reference_id' => 'contract-payment-001',
            'status' => 'pending',
            'amount' => 2400,
            'data' => [
                'project_id' => $project->id,
                'contract_id' => $contract->id,
            ],
        ]);

        $this->actingAs($freelancer)
            ->get(route('freelancer.contracts.index'))
            ->assertOk()
            ->assertSee('Delivery Workspace')
            ->assertSee('Growth consulting sprint')
            ->assertSee('contract-payment-001')
            ->assertSee('Active contracts');
    }
}
