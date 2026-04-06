<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Project;
use App\Models\Proposal;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientProposalDecisionTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_can_accept_a_proposal_from_project_workspace()
    {
        $client = User::factory()->create();
        $freelancer = User::factory()->create();
        $otherFreelancer = User::factory()->create();

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
        $otherFreelancer->roles()->attach($freelancerRole);

        $category = Category::create([
            'name' => 'Engineering',
            'slug' => 'engineering',
        ]);

        $project = Project::withoutGlobalScope('active')->create([
            'title' => 'Client workspace decision',
            'desc' => 'Pick the strongest proposal and continue delivery.',
            'category_id' => $category->id,
            'user_id' => $client->id,
            'status' => 'open',
            'type' => 'fixed',
            'budget' => 3200,
        ]);

        $proposal = Proposal::create([
            'freelancer_id' => $freelancer->id,
            'project_id' => $project->id,
            'description' => 'Primary proposal',
            'cost' => 3000,
            'duration' => 21,
            'duration_unit' => 'day',
            'status' => 'pending',
        ]);

        $otherProposal = Proposal::create([
            'freelancer_id' => $otherFreelancer->id,
            'project_id' => $project->id,
            'description' => 'Secondary proposal',
            'cost' => 2900,
            'duration' => 18,
            'duration_unit' => 'day',
            'status' => 'pending',
        ]);

        $this->actingAs($client)
            ->patch(route('client.projects.proposals.update', [$project, $proposal]), [
                'status' => 'accepted',
            ])
            ->assertRedirect(route('client.projects.show', $project));

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
            'status' => 'in-progress',
        ]);
    }
}
