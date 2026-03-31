<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Contract;
use App\Models\Project;
use App\Models\Proposal;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PortfolioDemoSeeder extends Seeder
{
    public function run()
    {
        $clientRole = Role::where('name', 'client')->first();
        $freelancerRole = Role::where('name', 'freelancer')->first();

        $clients = [
            [
                'name' => 'Nora Hassan',
                'email' => 'client1@elancer.test',
                'mobile_number' => '+970590000101',
            ],
            [
                'name' => 'Sami Khaled',
                'email' => 'client2@elancer.test',
                'mobile_number' => '+970590000102',
            ],
        ];

        $freelancers = [
            [
                'name' => 'Maya Darwish',
                'email' => 'freelancer1@elancer.test',
                'mobile_number' => '+970590000201',
                'profile' => [
                    'first_name' => 'Maya',
                    'last_name' => 'Darwish',
                    'title' => 'UI/UX Designer',
                    'country' => 'Palestine',
                    'gender' => 'female',
                    'desc' => 'Product designer focused on clean dashboards, landing pages, and conversion-first flows.',
                    'verified' => true,
                    'hourly_rate' => 35,
                ],
            ],
            [
                'name' => 'Omar Saeed',
                'email' => 'freelancer2@elancer.test',
                'mobile_number' => '+970590000202',
                'profile' => [
                    'first_name' => 'Omar',
                    'last_name' => 'Saeed',
                    'title' => 'Laravel Backend Developer',
                    'country' => 'Jordan',
                    'gender' => 'male',
                    'desc' => 'Backend specialist building APIs, admin dashboards, and payment-ready Laravel apps.',
                    'verified' => true,
                    'hourly_rate' => 45,
                ],
            ],
            [
                'name' => 'Lina Salem',
                'email' => 'freelancer3@elancer.test',
                'mobile_number' => '+970590000203',
                'profile' => [
                    'first_name' => 'Lina',
                    'last_name' => 'Salem',
                    'title' => 'Content Strategist',
                    'country' => 'UAE',
                    'gender' => 'female',
                    'desc' => 'Content and SEO strategist for bilingual websites, product launches, and service brands.',
                    'verified' => true,
                    'hourly_rate' => 28,
                ],
            ],
        ];

        $clientUsers = collect($clients)->map(function (array $data) use ($clientRole) {
            $user = $this->upsertUser($data);
            $user->roles()->syncWithoutDetaching([$clientRole->id]);

            return $user;
        });

        $freelancerUsers = collect($freelancers)->map(function (array $data) use ($freelancerRole) {
            $user = $this->upsertUser($data);
            $user->roles()->syncWithoutDetaching([$freelancerRole->id]);
            $user->freelancer()->updateOrCreate(
                ['user_id' => $user->id],
                $data['profile']
            );

            return $user;
        });

        $categories = [
            'laravel' => Category::where('slug', 'laravel')->firstOrFail(),
            'ui-design' => Category::where('slug', 'ui-design')->firstOrFail(),
            'seo' => Category::where('slug', 'seo')->firstOrFail(),
            'api-integrations' => Category::where('slug', 'api-integrations')->firstOrFail(),
            'brand-identity' => Category::where('slug', 'brand-identity')->firstOrFail(),
        ];

        $projects = [
            [
                'title' => 'Portfolio-grade freelancer marketplace refresh',
                'desc' => 'Rebuild the marketplace homepage and dashboard flow with polished UX, stronger hierarchy, and clean seeded content for demo presentations.',
                'category_id' => $categories['ui-design']->id,
                'user_id' => $clientUsers[0]->id,
                'status' => 'open',
                'type' => 'fixed',
                'budget' => 1800,
                'tags' => ['UX Audit', 'Landing Page', 'Dashboard'],
            ],
            [
                'title' => 'Laravel API for service booking platform',
                'desc' => 'Create a secure Laravel API with auth, project management, proposal flows, and clean resource responses for mobile and web clients.',
                'category_id' => $categories['laravel']->id,
                'user_id' => $clientUsers[0]->id,
                'status' => 'open',
                'type' => 'hourly',
                'budget' => 55,
                'tags' => ['Laravel', 'REST API', 'Sanctum'],
            ],
            [
                'title' => 'SEO content sprint for Arabic SaaS website',
                'desc' => 'Need high-converting landing copy, metadata planning, and a short editorial calendar for a bilingual SaaS product.',
                'category_id' => $categories['seo']->id,
                'user_id' => $clientUsers[1]->id,
                'status' => 'open',
                'type' => 'fixed',
                'budget' => 900,
                'tags' => ['SEO', 'Arabic Content', 'Growth'],
            ],
            [
                'title' => 'Payment gateway integration for client dashboard',
                'desc' => 'Integrate hosted payment checkout, callback handling, and transaction logging into an existing Laravel admin dashboard.',
                'category_id' => $categories['api-integrations']->id,
                'user_id' => $clientUsers[1]->id,
                'status' => 'open',
                'type' => 'fixed',
                'budget' => 1400,
                'tags' => ['Payments', 'Laravel', 'Webhooks'],
            ],
            [
                'title' => 'Brand identity starter kit for boutique studio',
                'desc' => 'Design a focused visual identity package with logo direction, colors, typography, and social profile assets.',
                'category_id' => $categories['brand-identity']->id,
                'user_id' => $clientUsers[0]->id,
                'status' => 'closed',
                'type' => 'fixed',
                'budget' => 1200,
                'tags' => ['Branding', 'Logo', 'Guidelines'],
            ],
        ];

        $projectModels = collect($projects)->map(function (array $data) {
            $project = Project::updateOrCreate(
                ['title' => $data['title']],
                collect($data)->except('tags')->all()
            );

            $project->syncTags($data['tags']);

            return $project;
        });

        $proposalDefinitions = [
            [
                'freelancer_email' => 'freelancer1@elancer.test',
                'project_title' => 'Portfolio-grade freelancer marketplace refresh',
                'description' => 'I can redesign the browsing experience, simplify content blocks, and polish the portfolio flow with reusable components.',
                'cost' => 1650,
                'duration' => 3,
                'duration_unit' => 'week',
                'status' => 'accepted',
            ],
            [
                'freelancer_email' => 'freelancer2@elancer.test',
                'project_title' => 'Laravel API for service booking platform',
                'description' => 'I will structure the API, authentication, and resources around maintainable Laravel conventions and clean controller boundaries.',
                'cost' => 50,
                'duration' => 6,
                'duration_unit' => 'week',
                'status' => 'pending',
            ],
            [
                'freelancer_email' => 'freelancer3@elancer.test',
                'project_title' => 'SEO content sprint for Arabic SaaS website',
                'description' => 'I can deliver the content plan, metadata structure, and launch copy in Arabic and English with SEO alignment.',
                'cost' => 850,
                'duration' => 2,
                'duration_unit' => 'week',
                'status' => 'pending',
            ],
        ];

        foreach ($proposalDefinitions as $data) {
            $freelancer = $freelancerUsers->firstWhere('email', $data['freelancer_email']);
            $project = $projectModels->firstWhere('title', $data['project_title']);

            $proposal = Proposal::updateOrCreate(
                [
                    'freelancer_id' => $freelancer->id,
                    'project_id' => $project->id,
                ],
                [
                    'description' => $data['description'],
                    'cost' => $data['cost'],
                    'duration' => $data['duration'],
                    'duration_unit' => $data['duration_unit'],
                    'status' => $data['status'],
                ]
            );

            if ($data['status'] === 'accepted') {
                Contract::updateOrCreate(
                    ['proposal_id' => $proposal->id],
                    [
                        'freelancer_id' => $freelancer->id,
                        'project_id' => $project->id,
                        'cost' => $proposal->cost,
                        'type' => $project->type,
                        'start_on' => now()->subWeek()->toDateString(),
                        'end_on' => now()->addWeeks(2)->toDateString(),
                        'completed_on' => null,
                        'hours' => $project->type === 'hourly' ? 24 : 0,
                        'status' => 'active',
                    ]
                );
            }
        }
    }

    protected function upsertUser(array $data): User
    {
        $user = User::firstOrNew(['email' => $data['email']]);
        $user->name = $data['name'];
        $user->password = Hash::make('password123');
        $user->mobile_number = $data['mobile_number'];
        $user->email_verified_at = now();
        $user->save();

        return $user;
    }
}
