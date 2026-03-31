<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientProjectCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_can_create_view_update_and_delete_a_project()
    {
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Web Development',
            'slug' => 'web-development',
        ]);

        $this->actingAs($user)
            ->post(route('client.projects.store'), [
                'title' => 'Portfolio Website',
                'desc' => 'Build a clean portfolio website.',
                'type' => 'fixed',
                'budget' => 1200,
                'category_id' => $category->id,
                'tags' => 'laravel, design',
            ])
            ->assertRedirect(route('client.projects.index'));

        $project = Project::withoutGlobalScope('active')->first();

        $this->assertNotNull($project);
        $this->assertSame('open', $project->status);
        $this->assertSame($user->id, $project->user_id);
        $this->assertEqualsCanonicalizing(
            ['laravel', 'design'],
            $project->tags()->pluck('slug')->all()
        );

        $this->actingAs($user)
            ->get(route('client.projects.show', $project))
            ->assertOk()
            ->assertSee('Portfolio Website');

        $this->actingAs($user)
            ->put(route('client.projects.update', $project), [
                'title' => 'Portfolio Website Refresh',
                'desc' => 'Update the portfolio website with a cleaner layout.',
                'type' => 'hourly',
                'budget' => 80,
                'category_id' => $category->id,
                'tags' => '',
            ])
            ->assertRedirect(route('client.projects.index'));

        $project->refresh();

        $this->assertSame('Portfolio Website Refresh', $project->title);
        $this->assertSame('hourly', $project->type);
        $this->assertCount(0, $project->tags);

        $this->actingAs($user)
            ->delete(route('client.projects.destroy', $project))
            ->assertRedirect(route('client.projects.index'));

        $this->assertDatabaseMissing('projects', [
            'id' => $project->id,
        ]);
    }
}
