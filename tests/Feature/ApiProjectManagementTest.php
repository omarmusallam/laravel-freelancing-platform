<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApiProjectManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_api_user_creates_project_for_themselves()
    {
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'API Category',
            'slug' => 'api-category',
        ]);

        Sanctum::actingAs($user, ['projects.update', 'projects.delete']);

        $response = $this->postJson('/api/projects', [
            'title' => 'API owned project',
            'desc' => 'Created through the API.',
            'type' => 'fixed',
            'budget' => 1500,
            'category_id' => $category->id,
            'tags' => 'api,backend',
        ]);

        $response->assertCreated()
            ->assertJsonPath('title', 'API owned project')
            ->assertJsonPath('user.id', $user->id);

        $this->assertDatabaseHas('projects', [
            'title' => 'API owned project',
            'user_id' => $user->id,
        ]);
    }

    public function test_api_owner_can_update_project_description_using_desc_field()
    {
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'API Updates',
            'slug' => 'api-updates',
        ]);

        $project = Project::withoutGlobalScope('active')->create([
            'title' => 'API update target',
            'desc' => 'Old description.',
            'type' => 'fixed',
            'budget' => 900,
            'status' => 'open',
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);

        Sanctum::actingAs($user, ['projects.update']);

        $this->putJson('/api/projects/' . $project->id, [
            'desc' => 'Updated API description.',
        ])->assertOk()
            ->assertJsonPath('description', 'Updated API description.');

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'desc' => 'Updated API description.',
        ]);
    }
}
