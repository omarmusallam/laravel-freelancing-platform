<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectBrowseTest extends TestCase
{
    use RefreshDatabase;

    public function test_projects_browse_page_can_be_rendered()
    {
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Web Development',
            'slug' => 'web-development',
        ]);

        Project::create([
            'title' => 'Build landing page',
            'desc' => 'Need a polished landing page for a startup.',
            'category_id' => $category->id,
            'user_id' => $user->id,
            'status' => 'open',
            'type' => 'fixed',
            'budget' => 900,
        ]);

        $response = $this->get('/projects');

        $response->assertOk();
        $response->assertSee('Browse Projects');
        $response->assertSee('Build landing page');
    }

    public function test_projects_browse_page_supports_filters()
    {
        $user = User::factory()->create();

        $design = Category::create([
            'name' => 'Design',
            'slug' => 'design',
        ]);

        $development = Category::create([
            'name' => 'Development',
            'slug' => 'development',
        ]);

        Project::create([
            'title' => 'UI refresh',
            'desc' => 'Improve onboarding flow.',
            'category_id' => $design->id,
            'user_id' => $user->id,
            'status' => 'open',
            'type' => 'fixed',
            'budget' => 700,
        ]);

        Project::create([
            'title' => 'API integration',
            'desc' => 'Connect third-party API.',
            'category_id' => $development->id,
            'user_id' => $user->id,
            'status' => 'open',
            'type' => 'hourly',
            'budget' => 50,
        ]);

        $response = $this->get('/projects?category=' . $development->id . '&type=hourly&q=API');

        $response->assertOk();
        $response->assertSee('API integration');
        $response->assertDontSee('UI refresh');
    }
}
