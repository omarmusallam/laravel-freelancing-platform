<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Project;
use App\Models\User;
use App\Notifications\NewPropsalNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ProposalSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_freelancer_can_submit_a_proposal_to_an_open_project()
    {
        Notification::fake();

        $client = User::factory()->create();
        $freelancer = User::factory()->create();
        $category = Category::create([
            'name' => 'Development',
            'slug' => 'development',
        ]);

        $project = Project::withoutGlobalScope('active')->create([
            'title' => 'Build API',
            'desc' => 'Create a REST API.',
            'category_id' => $category->id,
            'user_id' => $client->id,
            'status' => 'open',
            'type' => 'fixed',
            'budget' => 1500,
        ]);

        $this->actingAs($freelancer)
            ->post(route('freelancer.proposals.store', $project), [
                'description' => 'I can deliver this API quickly and cleanly.',
                'cost' => 1400,
                'duration' => 10,
                'duration_unit' => 'day',
            ])
            ->assertRedirect(route('projects.show', $project));

        $this->assertDatabaseHas('proposals', [
            'freelancer_id' => $freelancer->id,
            'project_id' => $project->id,
            'status' => 'pending',
        ]);

        Notification::assertSentTo($client, NewPropsalNotification::class);
    }

    public function test_user_cannot_submit_a_proposal_to_their_own_project()
    {
        Notification::fake();

        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Design',
            'slug' => 'design',
        ]);

        $project = Project::withoutGlobalScope('active')->create([
            'title' => 'Brand update',
            'desc' => 'Refresh the visual identity.',
            'category_id' => $category->id,
            'user_id' => $user->id,
            'status' => 'open',
            'type' => 'fixed',
            'budget' => 900,
        ]);

        $this->actingAs($user)
            ->post(route('freelancer.proposals.store', $project), [
                'description' => 'I should not be able to apply here.',
                'cost' => 800,
                'duration' => 7,
                'duration_unit' => 'day',
            ])
            ->assertRedirect(route('projects.show', $project));

        $this->assertDatabaseCount('proposals', 0);
        Notification::assertNothingSent();
    }
}
