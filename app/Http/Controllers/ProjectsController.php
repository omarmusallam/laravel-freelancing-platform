<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use App\Models\Proposal;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type');
        $type = is_string($type) && $type !== '' ? $type : null;
        $categoryId = $request->input('category');
        $categoryId = is_numeric($categoryId) ? (int) $categoryId : null;

        $categories = Category::query()
            ->withCount('projects')
            ->with(['children' => fn ($query) => $query->withCount('projects')])
            ->orderByRaw('CASE WHEN parent_id IS NULL THEN 0 ELSE 1 END')
            ->orderBy('name')
            ->get();

        $selectedCategory = $categoryId ? $categories->firstWhere('id', $categoryId) : null;
        $selectedCategoryIds = $selectedCategory
            ? collect([$selectedCategory->id])
                ->merge($selectedCategory->children->pluck('id'))
                ->filter()
                ->unique()
                ->values()
            : collect();

        $projects = Project::query()
            ->with(['category.parent', 'tags', 'user'])
            ->withCount('proposals')
            ->filter([
                'type' => $type,
                'budget_min' => $request->input('budget_min'),
                'budget_max' => $request->input('budget_max'),
            ])
            ->when($selectedCategoryIds->isNotEmpty(), function ($builder) use ($selectedCategoryIds) {
                $builder->whereIn('category_id', $selectedCategoryIds);
            })
            ->when($request->filled('q'), function ($builder) use ($request) {
                $builder->where(function ($query) use ($request) {
                    $query->where('title', 'like', '%' . $request->q . '%')
                        ->orWhere('desc', 'like', '%' . $request->q . '%');
                });
            })
            ->latest()
            ->paginate(9)
            ->withQueryString();

        $projectCollection = $projects->getCollection();
        $stats = [
            'results' => $projects->total(),
            'fixed' => $projectCollection->where('type', Project::TYPE_FIXED)->count(),
            'hourly' => $projectCollection->where('type', Project::TYPE_HOURLY)->count(),
            'budget_projects' => $projectCollection->where('budget', '>', 0)->count(),
        ];

        return view('projects.index', [
            'projects' => $projects,
            'categories' => $categories,
            'filters' => $request->only(['q', 'category', 'type', 'budget_min', 'budget_max']),
            'types' => Project::types(),
            'stats' => $stats,
            'selectedCategory' => $selectedCategory,
        ]);
    }

    public function show(Project $project)
    {
        $user = auth()->user();
        $canViewNonOpenProject = false;

        if ($user) {
            $canViewNonOpenProject =
                (int) $project->user_id === (int) $user->id
                || $project->proposals()->where('freelancer_id', $user->id)->exists();
        }

        if (auth('admin')->check()) {
            $canViewNonOpenProject = true;
        }

        if ($project->status !== 'open' && !$canViewNonOpenProject) {
            abort(404);
        }

        $project->load(['user.freelancer', 'category.parent', 'tags', 'proposals.freelancer']);

        $similarProjects = Project::query()
            ->where('id', '!=', $project->id)
            ->where('category_id', $project->category_id)
            ->latest()
            ->limit(3)
            ->get();

        return view('projects.show', [
            'project' => $project,
            'units' => Proposal::units(),
            'similarProjects' => $similarProjects,
            'shareUrl' => route('projects.show', $project),
        ]);
    }
}
