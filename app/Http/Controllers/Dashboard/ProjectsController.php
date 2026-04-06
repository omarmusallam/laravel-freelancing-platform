<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProjectsController extends Controller
{
    public function index(Request $request)
    {
        $query = trim((string) $request->input('q', ''));
        $status = $request->input('status');
        $type = $request->input('type');

        $projectsQuery = Project::withoutGlobalScope('active');

        $projects = $projectsQuery
            ->with(['user', 'category', 'tags'])
            ->when($query !== '', function ($builder) use ($query) {
                $builder->where(function ($search) use ($query) {
                    $search->where('title', 'like', '%' . $query . '%')
                        ->orWhere('desc', 'like', '%' . $query . '%')
                        ->orWhereHas('user', function ($userQuery) use ($query) {
                            $userQuery->where('name', 'like', '%' . $query . '%')
                                ->orWhere('email', 'like', '%' . $query . '%');
                        });
                });
            })
            ->when(in_array($status, ['open', 'in-progress', 'closed'], true), function ($builder) use ($status) {
                $builder->where('projects.status', $status);
            })
            ->when(in_array($type, ['fixed', 'hourly'], true), function ($builder) use ($type) {
                $builder->where('projects.type', $type);
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $stats = [
            'open' => Project::query()->count(),
            'in_progress' => Project::withoutGlobalScope('active')->where('status', 'in-progress')->count(),
            'closed' => Project::withoutGlobalScope('active')->where('status', 'closed')->count(),
            'budget' => Project::withoutGlobalScope('active')->sum('budget'),
        ];

        return view('dashboard.projects.index', [
            'projects' => $projects,
            'query' => $query,
            'status' => $status,
            'type' => $type,
            'stats' => $stats,
        ]);
    }

    public function show($project)
    {
        $project = Project::withoutGlobalScope('active')
            ->with(['user', 'category.parent', 'tags', 'proposals.freelancer'])
            ->findOrFail($project);

        return view('dashboard.projects.show', [
            'project' => $project,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, $project)
    {
        $project = Project::withoutGlobalScope('active')->findOrFail($project);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'desc' => ['required', 'string'],
            'type' => ['required', Rule::in(['fixed', 'hourly'])],
            'status' => ['required', Rule::in(['open', 'in-progress', 'closed'])],
            'budget' => ['nullable', 'numeric', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
        ]);

        $project->update($data);

        return redirect()
            ->route('dashboard.projects.show', $project)
            ->with('success', 'Project updated successfully.');
    }

    public function bulk(Request $request)
    {
        $data = $request->validate([
            'project_ids' => ['required', 'array'],
            'project_ids.*' => ['integer', 'exists:projects,id'],
            'action' => ['required', Rule::in(['open', 'in-progress', 'closed', 'delete'])],
        ]);

        $projects = Project::withoutGlobalScope('active')->whereIn('id', $data['project_ids']);

        if ($data['action'] === 'delete') {
            $projects->delete();
        } else {
            $projects->update(['status' => $data['action']]);
        }

        return redirect()
            ->route('dashboard.projects.index')
            ->with('success', 'Bulk project action completed successfully.');
    }

    public function destroy($project)
    {
        $project = Project::withoutGlobalScope('active')->findOrFail($project);

        $project->delete();

        return redirect()
            ->route('dashboard.projects.index')
            ->with('success', 'Project deleted successfully.');
    }
}
