<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Contract;
use App\Models\Project;
use App\Models\Proposal;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ClientPaymentInitiationTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_can_start_a_payment_for_their_contract()
    {
        Http::fake([
            '*' => Http::response([
                'success' => true,
                'code' => 2004,
                'data' => ['session_id' => 'session-123'],
            ], 200),
        ]);

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
            'name' => 'Product',
            'slug' => 'product',
        ]);

        $project = Project::withoutGlobalScope('active')->create([
            'title' => 'Contract payment project',
            'desc' => 'A client should pay against the accepted contract.',
            'category_id' => $category->id,
            'user_id' => $client->id,
            'status' => 'in-progress',
            'type' => 'fixed',
            'budget' => 1800,
        ]);

        $proposal = Proposal::create([
            'freelancer_id' => $freelancer->id,
            'project_id' => $project->id,
            'description' => 'Accepted proposal',
            'cost' => 1750,
            'duration' => 10,
            'duration_unit' => 'day',
            'status' => 'accepted',
        ]);

        $contract = Contract::create([
            'proposal_id' => $proposal->id,
            'freelancer_id' => $freelancer->id,
            'project_id' => $project->id,
            'cost' => 1750,
            'type' => 'fixed',
            'start_on' => now()->toDateString(),
            'end_on' => now()->addDays(10)->toDateString(),
            'status' => 'active',
        ]);

        $this->actingAs($client)
            ->get(route('payments.create', ['contract' => $contract->id]))
            ->assertRedirect('https://uatcheckout.thawani.om/pay/session-123?key=' . config('services.thawani.publishable_key'));

        $this->assertDatabaseHas('payments', [
            'user_id' => $client->id,
            'reference_id' => 'session-123',
            'amount' => 1750.0,
            'status' => 'pending',
        ]);
    }
}
