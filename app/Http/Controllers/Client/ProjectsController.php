<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ProjectRequest;
use App\Models\Category;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $projects = $this->ownedProjects($user)
            ->high()
            ->with('category.parent', 'tags')
            ->paginate();

        return view('client.projects.index', [
            'projects' => $projects,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('client.projects.create', [
            'project' => new Project(),
            'types' => Project::types(),
            'categories' => $this->categories(),
            'tags' => [],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        $user = $request->user();

        $data = $request->except('attachments');
        $data['status'] = $data['status'] ?? 'open';
        $data['attachments'] = $this->uploadAttachments($request) ?? [];

        $project = $user->projects()->create($data);
        $tags = $this->parseTags($request->input('tags'));
        $project->syncTags($tags);

        return redirect()
            ->route('client.projects.index')
            ->with('success', 'Project added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = $this->ownedProjects(Auth::user())
            ->with('category.parent', 'tags')
            ->findOrFail($id);

        return view('client.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = $this->ownedProjects(Auth::user())->findOrFail($id);

        return view('client.projects.edit', [
            'project' => $project,
            'types' => Project::types(),
            'categories' => $this->categories(),
            'tags' => $project->tags()->pluck('name')->toArray(),
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\ProjectRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, $id)
    {
        $project = $this->ownedProjects(Auth::user())->findOrFail($id);

        $data = $request->except('attachments');
        if ($request->attachments) {
            $data['attachments'] = array_merge(($project->attachments ?? []), $this->uploadAttachments($request));
        }

        $project->update($data);
        $tags = $this->parseTags($request->input('tags'));
        $project->syncTags($tags);

        return redirect()
            ->route('client.projects.index')
            ->with('success', 'Project updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = $this->ownedProjects(Auth::user())->findOrFail($id);
        $project->delete();

        foreach ((array) ($project->attachments ?? []) as $file) {
            Storage::disk('public')->delete($file);
        }

        return redirect()
            ->route('client.projects.index')
            ->with('success', 'Project deleted');
    }

    protected function categories()
    {
        return Category::pluck('name', 'id')->toArray();
    }

    protected function ownedProjects($user)
    {
        return $user->projects()->withoutGlobalScope('active');
    }

    protected function uploadAttachments(Request $request)
    {
        if (!$request->hasFile('attachments')) {
            return;
        }
        $files = $request->file('attachments');
        $attachments = [];
        foreach ($files as $file) {
            if ($file->isValid()) {
                $path = $file->store('/attachments', [
                    'disk' => 'uploads',
                ]);
                $attachments[] = $path;
            }
        }
        return $attachments;
    }

    protected function parseTags(?string $tags): array
    {
        if (!$tags) {
            return [];
        }

        return collect(explode(',', $tags))
            ->map(fn ($tag) => trim($tag))
            ->filter()
            ->values()
            ->all();
    }
}
