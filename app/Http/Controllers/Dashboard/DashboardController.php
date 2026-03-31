<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Message;
use App\Models\Project;
use App\Models\Proposal;
use App\Models\Role;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'admins' => Admin::count(),
            'users' => User::count(),
            'projects' => Project::withoutGlobalScope('active')->count(),
            'open_projects' => Project::query()->count(),
            'proposals' => Proposal::count(),
            'messages' => Message::count(),
            'categories' => Category::withTrashed()->count(),
            'roles' => Role::count(),
        ];

        return view('dashboard', [
            'stats' => $stats,
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
        ]);
    }
}
