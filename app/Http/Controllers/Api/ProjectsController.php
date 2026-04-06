<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ProjectsController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:sanctum'])->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $entries = Project::latest()
            ->with([
                'user:id,name',
                'category:id,name',
                'tags:id,name'
            ])
            ->paginate();

        // return $entries;
        return ProjectResource::collection($entries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        $user = $request->user();

        $data = $request->except('attachments');
        $data['status'] = $data['status'] ?? 'open';

        $project = $user->projects()->create($data);

        $tags = $this->parseTags($request->input('tags'));
        $project->syncTags($tags);

        return (new ProjectResource($project->load(['category', 'tags', 'user'])))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return new ProjectResource($project);

        // return $project->load(['category:id,name', 'user', 'tags']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'desc' => ['sometimes', 'required', 'string'],
            'type' => ['sometimes', 'required', 'in:hourly,fixed'],
            'category_id' => ['sometimes', 'required', 'exists:categories,id'],
            'budget' => ['nullable', 'numeric', 'min:0'],
            'tags' => ['nullable', 'string'],
        ]);

        $project = Project::withoutGlobalScope('active')->findOrFail($id);
        $user = $request->user();

        if ((int) $project->user_id !== (int) $user->id && !$user->tokenCan('projects.update')) {
            return Response::json([
                'message' => 'Permission denied!',
            ], 403);
        }

        $tags = $data['tags'] ?? null;
        unset($data['tags']);

        $project->update($data);

        if ($tags !== null) {
            $project->syncTags($this->parseTags($tags));
        }

        return new ProjectResource($project->fresh()->load(['category', 'tags', 'user']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $user = request()->user();

        if ((int) $project->user_id !== (int) $user->id && !$user->tokenCan('projects.delete')) {
            return Response::json([
                'message' => 'Permission denied!',
            ], 403);
        }

        $project->delete();

        if ($project->attachments) {
            foreach ($project->attachments as $file) {
                Storage::disk('public')->delete($file);
            }
        }

        return [
            'message' => 'Project deleted',
        ];
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
