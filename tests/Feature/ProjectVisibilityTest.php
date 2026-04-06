<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Project;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_open_project_is_hidden_from_unrelated_visitors()
    {
        $owner = User::factory()->create();
        $viewer = User::factory()->create();
        $category = Category::create([
            'name' => 'Operations',
            'slug' => 'operations',
        ]);

        $project = Project::withoutGlobalScope('active')->create([
            'title' => 'Private archived project',
            'desc' => 'Closed project should not be public.',
            'category_id' => $category->id,
            'user_id' => $owner->id,
            'status' => 'closed',
            'type' => 'fixed',
            'budget' => 800,
        ]);

        $this->actingAs($viewer)
            ->get(route('projects.show', $project))
            ->assertNotFound();
    }

    public function test_non_open_project_can_be_viewed_by_owner_and_participating_freelancer()
    {
        $owner = User::factory()->create();
        $freelancer = User::factory()->create();
        $category = Category::create([
            'name' => 'Development',
            'slug' => 'development',
        ]);

        $project = Project::withoutGlobalScope('active')->create([
            'title' => 'In progress portal',
            'desc' => 'In progress project should remain accessible to stakeholders.',
            'category_id' => $category->id,
            'user_id' => $owner->id,
            'status' => 'in-progress',
            'type' => 'fixed',
            'budget' => 1900,
        ]);

        Proposal::create([
            'freelancer_id' => $freelancer->id,
            'project_id' => $project->id,
            'description' => 'Working on this project.',
            'cost' => 1800,
            'duration' => 3,
            'duration_unit' => 'week',
            'status' => 'accepted',
        ]);

        $this->actingAs($owner)
            ->get(route('projects.show', $project))
            ->assertOk()
            ->assertSee('In progress portal');

        $this->actingAs($freelancer)
            ->get(route('projects.show', $project))
            ->assertOk()
            ->assertSee('In progress portal');
    }
}
