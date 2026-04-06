<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Contract;
use App\Models\Message;
use App\Models\Payment;
use App\Models\Project;
use App\Models\Proposal;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index()
    {
        $projectsQuery = Project::withoutGlobalScope('active');

        $stats = [
            'admins' => Admin::count(),
            'users' => User::count(),
            'projects' => (clone $projectsQuery)->count(),
            'open_projects' => Project::query()->count(),
            'in_progress_projects' => (clone $projectsQuery)->where('status', 'in-progress')->count(),
            'closed_projects' => (clone $projectsQuery)->where('status', 'closed')->count(),
            'proposals' => Proposal::count(),
            'accepted_proposals' => Proposal::where('status', 'accepted')->count(),
            'contracts' => Contract::count(),
            'active_contracts' => Contract::where('status', 'active')->count(),
            'completed_contracts' => Contract::where('status', 'completed')->count(),
            'payments' => Payment::count(),
            'payment_volume' => Payment::where('status', 'success')->sum('amount'),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'failed_payments' => Payment::where('status', 'failed')->count(),
            'messages' => Message::count(),
            'unread_messages' => Message::whereNull('read_at')->count(),
            'categories' => Category::withTrashed()->count(),
            'roles' => Role::count(),
        ];

        $actionQueue = [
            [
                'label' => 'Unread messages',
                'count' => $stats['unread_messages'],
                'description' => 'Conversations waiting for review from the admin team.',
                'url' => route('dashboard.messages.index', ['read' => 'unread']),
                'variant' => 'warning',
            ],
            [
                'label' => 'Pending payments',
                'count' => $stats['pending_payments'],
                'description' => 'Payments that still need verification or follow-up.',
                'url' => route('dashboard.payments.index', ['status' => 'pending']),
                'variant' => 'info',
            ],
            [
                'label' => 'Open projects',
                'count' => $stats['open_projects'],
                'description' => 'Open demand that can convert into new contracts.',
                'url' => route('dashboard.projects.index', ['status' => 'open']),
                'variant' => 'primary',
            ],
            [
                'label' => 'Pending proposals',
                'count' => Proposal::where('status', 'pending')->count(),
                'description' => 'Proposals that may need operational review or intervention.',
                'url' => route('dashboard.proposals.index', ['status' => 'pending']),
                'variant' => 'success',
            ],
        ];

        $activityFeed = $this->buildActivityFeed();

        return view('dashboard', [
            'stats' => $stats,
            'actionQueue' => $actionQueue,
            'activityFeed' => $activityFeed,
            'recentProjects' => Project::withoutGlobalScope('active')
                ->with(['user', 'category'])
                ->latest()
                ->limit(6)
                ->get(),
            'recentUsers' => User::with('roles')
                ->latest()
                ->limit(6)
                ->get(),
            'recentProposals' => Proposal::with(['project', 'freelancer'])
                ->latest()
                ->limit(6)
                ->get(),
            'recentContracts' => Contract::with(['project', 'freelancer'])
                ->latest()
                ->limit(6)
                ->get(),
            'recentPayments' => Payment::with('user')
                ->latest()
                ->limit(6)
                ->get(),
            'recentMessages' => Message::with(['sender', 'recipient'])
                ->latest()
                ->limit(6)
                ->get(),
        ]);
    }

    protected function buildActivityFeed(): Collection
    {
        $items = collect();

        Project::withoutGlobalScope('active')
            ->with('user')
            ->latest()
            ->limit(5)
            ->get()
            ->each(function (Project $project) use ($items) {
                $items->push([
                    'title' => 'Project updated',
                    'meta' => $project->title,
                    'description' => 'Client: ' . ($project->user->name ?? 'Deleted user') . ' · Status: ' . ucfirst($project->status),
                    'time' => $project->updated_at,
                    'url' => route('dashboard.projects.show', $project),
                    'icon' => 'fas fa-briefcase',
                    'variant' => 'primary',
                ]);
            });

        Proposal::with(['project', 'freelancer'])
            ->latest()
            ->limit(5)
            ->get()
            ->each(function (Proposal $proposal) use ($items) {
                $items->push([
                    'title' => 'Proposal submitted',
                    'meta' => $proposal->project->title ?? 'Deleted project',
                    'description' => ($proposal->freelancer->name ?? 'Unknown freelancer') . ' · ' . ucfirst($proposal->status),
                    'time' => $proposal->updated_at,
                    'url' => route('dashboard.proposals.show', $proposal),
                    'icon' => 'fas fa-file-signature',
                    'variant' => 'success',
                ]);
            });

        Contract::with(['project', 'freelancer'])
            ->latest()
            ->limit(5)
            ->get()
            ->each(function (Contract $contract) use ($items) {
                $items->push([
                    'title' => 'Contract moved',
                    'meta' => $contract->project->title ?? 'Deleted project',
                    'description' => ($contract->freelancer->name ?? 'Unknown freelancer') . ' · ' . ucfirst($contract->status),
                    'time' => $contract->updated_at,
                    'url' => route('dashboard.contracts.show', $contract),
                    'icon' => 'fas fa-file-contract',
                    'variant' => 'dark',
                ]);
            });

        Payment::with('user')
            ->latest()
            ->limit(5)
            ->get()
            ->each(function (Payment $payment) use ($items) {
                $items->push([
                    'title' => 'Payment received',
                    'meta' => $payment->reference_id,
                    'description' => ($payment->user->name ?? 'Guest / deleted user') . ' · ' . ucfirst($payment->status),
                    'time' => $payment->updated_at,
                    'url' => route('dashboard.payments.show', $payment),
                    'icon' => 'fas fa-credit-card',
                    'variant' => 'info',
                ]);
            });

        Message::with(['sender', 'recipient'])
            ->latest()
            ->limit(5)
            ->get()
            ->each(function (Message $message) use ($items) {
                $items->push([
                    'title' => 'Message sent',
                    'meta' => $message->sender->name ?? 'Deleted user',
                    'description' => 'To ' . ($message->recipient->name ?? 'Deleted user'),
                    'time' => $message->created_at,
                    'url' => route('dashboard.messages.show', $message),
                    'icon' => 'fas fa-comments',
                    'variant' => 'secondary',
                ]);
            });

        return $items
            ->sortByDesc('time')
            ->take(12)
            ->values();
    }
}
