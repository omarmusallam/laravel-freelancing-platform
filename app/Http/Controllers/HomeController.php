<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
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
            ->orderByRaw('CASE WHEN parent_id IS NULL THEN 0 ELSE 1 END')
            ->orderBy('name')
            ->get();

        $stats = [
            'projects' => Project::withoutGlobalScope('active')->count(),
            'open_projects' => Project::query()->count(),
            'freelancers' => \App\Models\Freelancer::count(),
        ];

        return view('home', [
            'recent_projects' => $recent_projects,
            'categories' => $categories,
            'stats' => $stats,
        ]);
    }
}
