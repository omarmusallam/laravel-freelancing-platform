<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contract;
use App\Models\Freelancer;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $recent_projects = Project::with('category.parent', 'tags')
            ->latest()
            ->where('status', '=', 'open')
            ->limit(5)
            ->get();

        $categories = Category::with('parent')
            ->withCount('projects')
            ->with(['children' => fn ($query) => $query->withCount('projects')])
            ->orderByRaw('CASE WHEN parent_id IS NULL THEN 0 ELSE 1 END')
            ->orderBy('name')
            ->get();

        $stats = [
            'projects' => Project::withoutGlobalScope('active')->count(),
            'open_projects' => Project::query()->count(),
            'freelancers' => Freelancer::count(),
            'clients' => User::count(),
            'categories' => Category::count(),
            'completed_contracts' => Contract::where('status', 'completed')->count(),
        ];

        $featuredFreelancers = Freelancer::with('user')
            ->whereNotNull('title')
            ->orderByDesc('verified')
            ->orderByDesc('hourly_rate')
            ->limit(4)
            ->get();

        return view('home-premium', [
            'recent_projects' => $recent_projects,
            'categories' => $categories,
            'stats' => $stats,
            'featuredFreelancers' => $featuredFreelancers,
        ]);
    }
}
