<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessControlTest extends TestCase
{
    use RefreshDatabase;

    public function test_freelancer_cannot_access_client_project_routes()
    {
        $freelancer = User::factory()->create();
        $freelancerRole = Role::create([
            'name' => 'freelancer',
            'abilities' => ['proposals.create'],
        ]);
        $freelancer->roles()->attach($freelancerRole);

        $this->actingAs($freelancer)
            ->get(route('client.projects.index'))
            ->assertForbidden();
    }

    public function test_client_cannot_access_freelancer_proposal_routes()
    {
        $client = User::factory()->create();
        $clientRole = Role::create([
            'name' => 'client',
            'abilities' => ['projects.create'],
        ]);
        $client->roles()->attach($clientRole);

        $category = Category::create([
            'name' => 'Design',
            'slug' => 'design',
        ]);

        $project = Project::withoutGlobalScope('active')->create([
            'title' => 'Protected proposal route',
            'desc' => 'Testing role protection.',
            'category_id' => $category->id,
            'user_id' => $client->id,
            'status' => 'open',
            'type' => 'fixed',
            'budget' => 900,
        ]);

        $this->actingAs($client)
            ->get(route('freelancer.proposals.create', $project))
            ->assertForbidden();
    }
}
