<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Contract;
use App\Models\Message;
use App\Models\Payment;
use App\Models\Project;
use App\Models\Proposal;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MarketplaceDemoSeeder extends Seeder
{
    protected array $categoryTagMap = [
        'laravel' => ['Laravel', 'PHP', 'MySQL', 'REST API', 'Admin Dashboard', 'Payment Gateway', 'Multi Tenancy'],
        'vue-js' => ['Vue.js', 'Frontend', 'SPA', 'Tailwind CSS', 'Component Library', 'Dashboard UI'],
        'api-integrations' => ['API Integration', 'Webhooks', 'OAuth', 'CRM', 'ERP', 'Third Party Services'],
        'wordpress' => ['WordPress', 'Elementor', 'WooCommerce', 'Theme Customization', 'Plugin Setup'],
        'e-commerce-development' => ['E-commerce', 'Checkout', 'Catalog', 'Inventory', 'Marketplace'],
        'ui-design' => ['UI Design', 'UX Audit', 'Wireframes', 'Design System', 'Landing Page', 'Figma'],
        'brand-identity' => ['Brand Identity', 'Logo Design', 'Guidelines', 'Typography', 'Packaging'],
        'marketing-assets' => ['Social Creatives', 'Ad Design', 'Campaign Assets', 'Banners', 'Brochure'],
        'motion-design' => ['Motion Design', 'Explainer Video', 'Animation', 'Storyboarding'],
        'presentation-design' => ['Pitch Deck', 'Investor Deck', 'Presentation Design', 'Slides'],
        'copywriting' => ['Copywriting', 'Website Copy', 'Sales Copy', 'Arabic Copy', 'English Copy'],
        'seo' => ['SEO', 'Technical SEO', 'Keyword Research', 'On Page SEO', 'Backlinks'],
        'social-media' => ['Social Media', 'Content Calendar', 'Community', 'Instagram', 'LinkedIn'],
        'email-marketing' => ['Email Marketing', 'CRM Flows', 'Newsletters', 'Retention'],
        'performance-marketing' => ['Google Ads', 'Meta Ads', 'CRO', 'Performance Marketing'],
        'flutter' => ['Flutter', 'Mobile App', 'Cross Platform', 'Firebase', 'Push Notifications'],
        'react-native' => ['React Native', 'Mobile App', 'Expo', 'App Store', 'Play Store'],
        'ios-apps' => ['iOS', 'Swift', 'Apple Sign In', 'Subscriptions'],
        'android-apps' => ['Android', 'Kotlin', 'Play Console', 'In App Billing'],
        'data-analysis' => ['Data Analysis', 'Excel', 'SQL', 'Forecasting', 'Reporting'],
        'dashboards-bi' => ['Power BI', 'Tableau', 'Dashboard', 'KPIs', 'Business Intelligence'],
        'ai-integrations' => ['OpenAI', 'AI Assistant', 'Chatbot', 'Automation', 'Knowledge Base'],
        'automation' => ['Automation', 'Zapier', 'Make', 'Workflows', 'No Code'],
        'virtual-assistance' => ['Virtual Assistant', 'Operations', 'Scheduling', 'Documentation'],
        'customer-support' => ['Customer Support', 'Help Desk', 'Live Chat', 'SOP'],
        'project-management' => ['Project Management', 'Agile', 'Roadmap', 'Sprint Planning'],
        'business-research' => ['Market Research', 'Competitor Analysis', 'Business Plan', 'Lead Generation'],
    ];

    protected array $clientProfiles = [
        ['name' => 'Nora Hassan', 'email' => 'nora.hassan@elancer.test', 'mobile_number' => '+970590100001', 'company' => 'Northstar Studio'],
        ['name' => 'Sami Khaled', 'email' => 'sami.khaled@elancer.test', 'mobile_number' => '+970590100002', 'company' => 'Cedar Commerce'],
        ['name' => 'Rana Odeh', 'email' => 'rana.odeh@elancer.test', 'mobile_number' => '+970590100003', 'company' => 'Atlas Clinics'],
        ['name' => 'Fadi Nasser', 'email' => 'fadi.nasser@elancer.test', 'mobile_number' => '+970590100004', 'company' => 'Pixel Harbor'],
        ['name' => 'Lama Yasin', 'email' => 'lama.yasin@elancer.test', 'mobile_number' => '+970590100005', 'company' => 'Bloom Education'],
        ['name' => 'Yousef Hamdan', 'email' => 'yousef.hamdan@elancer.test', 'mobile_number' => '+970590100006', 'company' => 'Orbit Logistics'],
        ['name' => 'Dina Saadeh', 'email' => 'dina.saadeh@elancer.test', 'mobile_number' => '+970590100007', 'company' => 'Olive Retail'],
        ['name' => 'Tariq Faris', 'email' => 'tariq.faris@elancer.test', 'mobile_number' => '+970590100008', 'company' => 'Mawrid Media'],
        ['name' => 'Mariam Shawa', 'email' => 'mariam.shawa@elancer.test', 'mobile_number' => '+970590100009', 'company' => 'Harbor Ventures'],
        ['name' => 'Kareem Zidan', 'email' => 'kareem.zidan@elancer.test', 'mobile_number' => '+970590100010', 'company' => 'Scale Ops'],
        ['name' => 'Haneen Abed', 'email' => 'haneen.abed@elancer.test', 'mobile_number' => '+970590100011', 'company' => 'Saha Wellness'],
        ['name' => 'Majd Awad', 'email' => 'majd.awad@elancer.test', 'mobile_number' => '+970590100012', 'company' => 'Peak Events'],
    ];

    protected array $freelancerProfiles = [
        ['name' => 'Maya Darwish', 'email' => 'maya.darwish@elancer.test', 'mobile_number' => '+970590200001', 'first_name' => 'Maya', 'last_name' => 'Darwish', 'title' => 'Senior UI/UX Designer', 'country' => 'Palestine', 'gender' => 'female', 'hourly_rate' => 42, 'verified' => true],
        ['name' => 'Omar Saeed', 'email' => 'omar.saeed@elancer.test', 'mobile_number' => '+970590200002', 'first_name' => 'Omar', 'last_name' => 'Saeed', 'title' => 'Laravel Backend Engineer', 'country' => 'Jordan', 'gender' => 'male', 'hourly_rate' => 48, 'verified' => true],
        ['name' => 'Lina Salem', 'email' => 'lina.salem@elancer.test', 'mobile_number' => '+970590200003', 'first_name' => 'Lina', 'last_name' => 'Salem', 'title' => 'SEO and Content Strategist', 'country' => 'UAE', 'gender' => 'female', 'hourly_rate' => 32, 'verified' => true],
        ['name' => 'Ahmad Qasem', 'email' => 'ahmad.qasem@elancer.test', 'mobile_number' => '+970590200004', 'first_name' => 'Ahmad', 'last_name' => 'Qasem', 'title' => 'Full Stack Developer', 'country' => 'Egypt', 'gender' => 'male', 'hourly_rate' => 44, 'verified' => true],
        ['name' => 'Sara Jaber', 'email' => 'sara.jaber@elancer.test', 'mobile_number' => '+970590200005', 'first_name' => 'Sara', 'last_name' => 'Jaber', 'title' => 'Brand Designer', 'country' => 'Saudi Arabia', 'gender' => 'female', 'hourly_rate' => 36, 'verified' => true],
        ['name' => 'Yazan Taha', 'email' => 'yazan.taha@elancer.test', 'mobile_number' => '+970590200006', 'first_name' => 'Yazan', 'last_name' => 'Taha', 'title' => 'Flutter Developer', 'country' => 'Palestine', 'gender' => 'male', 'hourly_rate' => 40, 'verified' => true],
        ['name' => 'Reem Khoury', 'email' => 'reem.khoury@elancer.test', 'mobile_number' => '+970590200007', 'first_name' => 'Reem', 'last_name' => 'Khoury', 'title' => 'Marketing Automation Specialist', 'country' => 'Lebanon', 'gender' => 'female', 'hourly_rate' => 31, 'verified' => true],
        ['name' => 'Basil Hijazi', 'email' => 'basil.hijazi@elancer.test', 'mobile_number' => '+970590200008', 'first_name' => 'Basil', 'last_name' => 'Hijazi', 'title' => 'Data Analyst', 'country' => 'Qatar', 'gender' => 'male', 'hourly_rate' => 38, 'verified' => true],
        ['name' => 'Nada Masri', 'email' => 'nada.masri@elancer.test', 'mobile_number' => '+970590200009', 'first_name' => 'Nada', 'last_name' => 'Masri', 'title' => 'Project Manager', 'country' => 'Palestine', 'gender' => 'female', 'hourly_rate' => 34, 'verified' => true],
        ['name' => 'Khaled Barakat', 'email' => 'khaled.barakat@elancer.test', 'mobile_number' => '+970590200010', 'first_name' => 'Khaled', 'last_name' => 'Barakat', 'title' => 'React Native Engineer', 'country' => 'Jordan', 'gender' => 'male', 'hourly_rate' => 43, 'verified' => true],
        ['name' => 'Tasneem Abu Eid', 'email' => 'tasneem.abueid@elancer.test', 'mobile_number' => '+970590200011', 'first_name' => 'Tasneem', 'last_name' => 'Abu Eid', 'title' => 'Copywriter and Editor', 'country' => 'UAE', 'gender' => 'female', 'hourly_rate' => 27, 'verified' => true],
        ['name' => 'Mohammad Najar', 'email' => 'mohammad.najar@elancer.test', 'mobile_number' => '+970590200012', 'first_name' => 'Mohammad', 'last_name' => 'Najar', 'title' => 'AI Product Integrator', 'country' => 'Saudi Arabia', 'gender' => 'male', 'hourly_rate' => 52, 'verified' => true],
    ];

    public function run()
    {
        FakerFactory::create()->seed(20260406);

        $clientRole = Role::where('name', 'client')->firstOrFail();
        $freelancerRole = Role::where('name', 'freelancer')->firstOrFail();

        $clients = collect($this->clientProfiles)
            ->map(fn (array $profile) => $this->createClient($profile, $clientRole->id));

        $freelancers = collect($this->freelancerProfiles)
            ->map(fn (array $profile) => $this->createFreelancer($profile, $freelancerRole->id));

        $childCategories = Category::query()
            ->whereNotNull('parent_id')
            ->with('parent')
            ->orderBy('name')
            ->get()
            ->keyBy('slug');

        $tags = $this->seedTags();
        $projects = collect();

        foreach ($childCategories as $category) {
            $projects = $projects->merge(
                $this->createProjectsForCategory($category, $clients, $tags)
            );
        }

        $this->seedProposalsAndContracts($projects, $freelancers);
        $this->seedMessages($clients, $freelancers, $projects);
        $this->seedPayments($clients);
    }

    protected function createClient(array $profile, int $roleId): User
    {
        $user = User::firstOrNew(['email' => $profile['email']]);
        $user->name = $profile['name'];
        $user->password = Hash::make('password123');
        $user->mobile_number = $profile['mobile_number'];
        $user->email_verified_at = now();
        $user->save();

        $user->roles()->syncWithoutDetaching([$roleId]);

        return $user;
    }

    protected function createFreelancer(array $profile, int $roleId): User
    {
        $user = User::firstOrNew(['email' => $profile['email']]);
        $user->name = $profile['name'];
        $user->password = Hash::make('password123');
        $user->mobile_number = $profile['mobile_number'];
        $user->email_verified_at = now();
        $user->save();

        $user->roles()->syncWithoutDetaching([$roleId]);

        $freelancerProfile = $user->freelancer()->firstOrNew(['user_id' => $user->id]);
        $freelancerProfile->forceFill([
            'first_name' => $profile['first_name'],
            'last_name' => $profile['last_name'],
            'title' => $profile['title'],
            'country' => $profile['country'],
            'gender' => $profile['gender'],
            'birthday' => Carbon::now()->subYears(rand(22, 37))->subDays(rand(10, 300))->toDateString(),
            'desc' => $this->freelancerBio($profile),
            'verified' => $profile['verified'],
            'hourly_rate' => $profile['hourly_rate'],
        ])->save();

        return $user;
    }

    protected function seedTags(): Collection
    {
        $tags = collect($this->categoryTagMap)
            ->flatten()
            ->unique()
            ->sort()
            ->values();

        return $tags->mapWithKeys(function (string $tagName) {
            $tag = Tag::updateOrCreate(
                ['slug' => Str::slug($tagName)],
                ['name' => $tagName]
            );

            return [$tag->slug => $tag];
        });
    }

    protected function createProjectsForCategory(Category $category, Collection $clients, Collection $tags): Collection
    {
        $projects = collect();
        $statuses = ['open', 'open', 'open', 'open', 'in-progress', 'closed'];

        for ($i = 1; $i <= 6; $i++) {
            $client = $clients->random();
            $status = $statuses[($i - 1) % count($statuses)];
            $type = $i % 2 === 0 ? Project::TYPE_HOURLY : Project::TYPE_FIXED;
            $budget = $type === Project::TYPE_HOURLY ? rand(22, 95) : rand(700, 8500);

            $project = Project::forceCreate([
                'user_id' => $client->id,
                'category_id' => $category->id,
                'title' => $this->projectTitle($category, $client, $i),
                'desc' => $this->projectDescription($category, $client, $type, $status, $i),
                'status' => $status,
                'type' => $type,
                'budget' => $budget,
                'created_at' => Carbon::now()->subDays(rand(1, 120)),
                'updated_at' => Carbon::now()->subDays(rand(0, 45)),
            ]);

            $projectTags = collect($this->categoryTagMap[$category->slug] ?? [])
                ->merge($this->genericTagsForType($type))
                ->unique()
                ->shuffle()
                ->take(rand(3, 5))
                ->map(fn (string $name) => Str::slug($name))
                ->values();

            $project->tags()->sync($tags->only($projectTags)->pluck('id')->all());
            $projects->push($project);
        }

        return $projects;
    }

    protected function seedProposalsAndContracts(Collection $projects, Collection $freelancers): void
    {
        foreach ($projects as $project) {
            $proposalCount = $project->status === 'closed' ? rand(2, 4) : rand(3, 6);
            $selectedFreelancers = $freelancers->shuffle()->take(min($proposalCount, $freelancers->count()));
            $acceptedProposal = null;

            foreach ($selectedFreelancers as $index => $freelancer) {
                $status = 'pending';

                if (in_array($project->status, ['in-progress', 'closed'], true) && $index === 0) {
                    $status = 'accepted';
                } elseif ($index === 1) {
                    $status = 'declined';
                }

                $durationUnits = ['day', 'week', 'month'];

                $proposal = Proposal::forceCreate([
                    'freelancer_id' => $freelancer->id,
                    'project_id' => $project->id,
                    'description' => $this->proposalDescription($freelancer, $project),
                    'cost' => $project->type === Project::TYPE_HOURLY
                        ? max(15, $project->budget - rand(0, 12))
                        : max(250, $project->budget - rand(80, 900)),
                    'duration' => $project->type === Project::TYPE_HOURLY ? rand(2, 12) : rand(1, 8),
                    'duration_unit' => $project->type === Project::TYPE_HOURLY ? 'week' : $durationUnits[array_rand($durationUnits)],
                    'status' => $status,
                    'created_at' => $project->created_at->copy()->addDays(rand(1, 10)),
                    'updated_at' => $project->created_at->copy()->addDays(rand(2, 14)),
                ]);

                if ($status === 'accepted') {
                    $acceptedProposal = $proposal;
                }
            }

            if ($acceptedProposal) {
                Contract::forceCreate([
                    'proposal_id' => $acceptedProposal->id,
                    'freelancer_id' => $acceptedProposal->freelancer_id,
                    'project_id' => $project->id,
                    'cost' => $acceptedProposal->cost,
                    'type' => $project->type,
                    'start_on' => $acceptedProposal->created_at->copy()->addDays(2)->toDateString(),
                    'end_on' => $acceptedProposal->created_at->copy()->addDays(rand(20, 75))->toDateString(),
                    'completed_on' => $project->status === 'closed'
                        ? $acceptedProposal->created_at->copy()->addDays(rand(30, 90))->toDateString()
                        : null,
                    'hours' => $project->type === Project::TYPE_HOURLY ? rand(12, 120) : 0,
                    'status' => $project->status === 'closed' ? 'completed' : 'active',
                    'created_at' => $acceptedProposal->created_at->copy()->addDay(),
                    'updated_at' => Carbon::now()->subDays(rand(0, 20)),
                ]);
            }
        }
    }

    protected function seedMessages(Collection $clients, Collection $freelancers, Collection $projects): void
    {
        $messageSnippets = [
            'Thanks for the detailed brief. I reviewed the scope and I can start with discovery this week.',
            'Sharing an updated estimate after checking the integrations and the expected delivery milestones.',
            'Can we align on the priority features for the first release so I can break down the implementation plan?',
            'I added notes about onboarding, approvals, and dashboard reporting to keep the workflow realistic.',
            'Please review the latest progress summary. The admin area and project listing are both ready for feedback.',
            'I can provide a cleaner proposal version with phased delivery if you want to keep the launch smaller.',
        ];

        foreach ($projects->shuffle()->take(18) as $project) {
            $client = $clients->firstWhere('id', $project->user_id);
            $freelancer = $freelancers->random();

            for ($i = 0; $i < 4; $i++) {
                $sender = $i % 2 === 0 ? $client : $freelancer;
                $recipient = $sender->id === $client->id ? $freelancer : $client;

                Message::forceCreate([
                    'sender_id' => $sender->id,
                    'recipient_id' => $recipient->id,
                    'message' => $messageSnippets[array_rand($messageSnippets)] . ' Project: ' . $project->title . '.',
                    'read_at' => $i < 3 ? Carbon::now()->subDays(rand(1, 15)) : null,
                    'created_at' => $project->created_at->copy()->addDays(rand(1, 20))->addMinutes($i * 13),
                    'updated_at' => $project->created_at->copy()->addDays(rand(1, 20))->addMinutes($i * 13),
                ]);
            }
        }
    }

    protected function seedPayments(Collection $clients): void
    {
        $gateways = ['thawani', 'stripe', 'manual-transfer'];
        $statuses = ['success', 'success', 'success', 'pending', 'failed'];

        foreach ($clients as $client) {
            for ($i = 1; $i <= 3; $i++) {
                Payment::forceCreate([
                    'user_id' => $client->id,
                    'gateway' => $gateways[array_rand($gateways)],
                    'reference_id' => 'PAY-' . strtoupper(Str::random(10)),
                    'status' => $statuses[array_rand($statuses)],
                    'amount' => rand(150, 2500),
                    'data' => [
                        'invoice' => 'INV-' . rand(10000, 99999),
                        'notes' => 'Demo payment generated for portfolio-quality seeded content.',
                    ],
                    'created_at' => Carbon::now()->subDays(rand(1, 60)),
                    'updated_at' => Carbon::now()->subDays(rand(0, 30)),
                ]);
            }
        }
    }

    protected function genericTagsForType(string $type): array
    {
        return $type === Project::TYPE_HOURLY
            ? ['Long Term', 'Support', 'Iteration', 'Maintenance']
            : ['MVP', 'Launch', 'Strategy', 'Delivery'];
    }

    protected function freelancerBio(array $profile): string
    {
        return sprintf(
            '%s works as a %s focused on polished delivery, clear communication, and business-friendly execution for growth-stage teams.',
            $profile['first_name'],
            $profile['title']
        );
    }

    protected function projectTitle(Category $category, User $client, int $index): string
    {
        $prefixes = [
            'Launch-ready',
            'Growth-focused',
            'High-conversion',
            'Scalable',
            'Operations-ready',
            'Portfolio-grade',
        ];

        $deliverables = [
            'platform refresh',
            'client portal',
            'service marketplace build',
            'campaign sprint',
            'dashboard redesign',
            'automation setup',
        ];

        return $prefixes[array_rand($prefixes)] . ' ' . $category->name . ' ' . $deliverables[($index - 1) % count($deliverables)] . ' for ' . Str::before($client->email, '@');
    }

    protected function projectDescription(Category $category, User $client, string $type, string $status, int $index): string
    {
        $companyName = Str::headline(Str::before($client->email, '@'));
        $typeLabel = $type === Project::TYPE_HOURLY ? 'hourly collaboration' : 'fixed-scope delivery';
        $statusLine = $status === 'open'
            ? 'We are ready to hire immediately and want strong examples plus a practical execution plan.'
            : 'This record is seeded to demonstrate ongoing and completed work across the platform.';

        return " {$companyName} needs support in {$category->name} with a {$typeLabel}. "
            . "The ideal freelancer should understand planning, communication, and structured delivery for a real client-facing workflow. "
            . "Scope includes discovery, execution, revision handling, and clean handoff notes for internal use. "
            . "Priority set {$index} focuses on professional presentation so the platform looks credible during testing and portfolio screenshots. "
            . $statusLine;
    }

    protected function proposalDescription(User $freelancer, Project $project): string
    {
        $title = optional($freelancer->freelancer)->title ?: 'specialist';

        return "{$freelancer->name} is applying as {$title}. I reviewed the project requirements, can structure the work into clear milestones, and will keep communication proactive while delivering a polished outcome that matches the requested scope for {$project->title}.";
    }
}
