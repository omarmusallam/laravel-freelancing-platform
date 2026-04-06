<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Contract;
use App\Models\Message;
use App\Models\Payment;
use App\Models\Project;
use App\Models\Proposal;
use App\Models\SiteSetting;
use App\Models\Tag;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MarketplaceSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_seeder_builds_large_demo_marketplace_content()
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertGreaterThanOrEqual(30, Category::count());
        $this->assertGreaterThanOrEqual(25, Category::whereNotNull('parent_id')->count());
        $this->assertGreaterThanOrEqual(70, Tag::count());
        $this->assertGreaterThanOrEqual(24, User::count());
        $this->assertGreaterThanOrEqual(100, Project::withoutGlobalScope('active')->count());
        $this->assertGreaterThanOrEqual(70, Project::query()->count());
        $this->assertGreaterThanOrEqual(250, Proposal::count());
        $this->assertGreaterThanOrEqual(20, Contract::count());
        $this->assertGreaterThanOrEqual(60, Message::count());
        $this->assertGreaterThanOrEqual(30, Payment::count());
        $this->assertSame(1, SiteSetting::count());
        $this->assertSame('Elancer Pro', SiteSetting::first()->site_name);
    }
}
