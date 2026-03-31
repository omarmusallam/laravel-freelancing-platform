<?php

namespace App\Http\Controllers;

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

        $projects = Project::query()
            ->with(['category.parent', 'tags', 'user'])
            ->filter([
                'type' => $type,
                'budget_min' => $request->input('budget_min'),
                'budget_max' => $request->input('budget_max'),
            ])
            ->when($categoryId, function ($builder) use ($categoryId) {
                $builder->where('category_id', $categoryId);
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

        return view('projects.index', [
            'projects' => $projects,
            'categories' => \App\Models\Category::with('parent')->orderByRaw('CASE WHEN parent_id IS NULL THEN 0 ELSE 1 END')->orderBy('name')->get(),
            'filters' => $request->only(['q', 'category', 'type', 'budget_min', 'budget_max']),
            'types' => Project::types(),
        ]);
    }

    public function show(Project $project)
    {
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
