<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Freelancer;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_renders_live_content()
    {
        $user = User::factory()->create();
        $user->freelancer()->create([
            'first_name' => 'Omar',
            'last_name' => 'Dev',
        ]);

        $category = Category::create([
            'name' => 'Mobile Apps',
            'slug' => 'mobile-apps',
        ]);

        Category::create([
            'name' => 'iOS Apps',
            'slug' => 'ios-apps',
            'parent_id' => $category->id,
        ]);

        Project::withoutGlobalScope('active')->create([
            'title' => 'Launch mobile MVP',
            'desc' => 'Need a polished MVP app.',
            'category_id' => $category->id,
            'user_id' => $user->id,
            'status' => 'open',
            'type' => 'fixed',
            'budget' => 2500,
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Mobile Apps')
            ->assertSee('iOS Apps')
            ->assertSee('Launch mobile MVP');
    }
}
