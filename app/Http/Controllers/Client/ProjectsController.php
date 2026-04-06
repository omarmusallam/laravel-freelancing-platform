<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ProjectRequest;
use App\Models\Category;
use App\Models\Payment;
use App\Models\Project;
use App\Models\Proposal;
use App\Models\Tag;
use App\Services\ProposalWorkflowService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProjectsController extends Controller
{
    public function __construct(protected ProposalWorkflowService $proposalWorkflow)
    {
    }

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
            ->withCount(['proposals', 'contracts'])
            ->paginate();

        $allProjects = $this->ownedProjects($user)->get();
        $stats = [
            'total' => $allProjects->count(),
            'open' => $allProjects->where('status', 'open')->count(),
            'in_progress' => $allProjects->where('status', 'in-progress')->count(),
            'closed' => $allProjects->where('status', 'closed')->count(),
        ];

        return view('client.projects.index', [
            'projects' => $projects,
            'stats' => $stats,
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
            ->with(['category.parent', 'tags', 'proposals.freelancer', 'proposals.contract', 'contracts'])
            ->findOrFail($id);

        $activeContract = $project->contracts
            ->sortByDesc('created_at')
            ->firstWhere('status', 'active')
            ?? $project->contracts->sortByDesc('created_at')->first();

        $payments = Payment::query()
            ->where('user_id', Auth::id())
            ->latest()
            ->get()
            ->filter(function (Payment $payment) use ($project) {
                return (int) data_get($payment->data, 'project_id') === (int) $project->id;
            })
            ->values();

        $stats = [
            'proposals' => $project->proposals->count(),
            'accepted_proposals' => $project->proposals->where('status', 'accepted')->count(),
            'contracts' => $project->contracts->count(),
            'attachments' => count((array) ($project->attachments ?? [])),
            'payments' => $payments->count(),
        ];

        return view('client.projects.show', compact('project', 'stats', 'activeContract', 'payments'));
    }

    public function updateProposal(Request $request, $projectId, $proposalId)
    {
        $project = $this->ownedProjects($request->user())->findOrFail($projectId);

        $proposal = $project->proposals()
            ->whereKey($proposalId)
            ->with(['project', 'freelancer', 'contract'])
            ->firstOrFail();

        if ($project->status === 'closed') {
            return redirect()
                ->route('client.projects.show', $project)
                ->with('error', 'Closed projects cannot change proposal decisions.');
        }

        $data = $request->validate([
            'status' => ['required', Rule::in(['accepted', 'declined'])],
        ]);

        $this->proposalWorkflow->applyDecision($proposal, [
            'description' => $proposal->description,
            'cost' => $proposal->cost,
            'duration' => $proposal->duration,
            'duration_unit' => $proposal->duration_unit,
            'status' => $data['status'],
        ]);

        return redirect()
            ->route('client.projects.show', $project)
            ->with(
                'success',
                $data['status'] === 'accepted'
                    ? 'Proposal accepted and contract workflow updated successfully.'
                    : 'Proposal declined successfully.'
            );
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
