<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Proposal;
use App\Notifications\NewPropsalNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProposalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::guard('web')->user();

        $proposals = $user->proposals()
            ->with(['project.category.parent', 'project.user'])
            ->latest()
            ->paginate();

        $allProposals = $user->proposals()->get();
        $stats = [
            'total' => $allProposals->count(),
            'pending' => $allProposals->where('status', 'pending')->count(),
            'accepted' => $allProposals->where('status', 'accepted')->count(),
            'declined' => $allProposals->where('status', 'declined')->count(),
        ];

        return view('freelancer.proposals.index', [
            'proposals' => $proposals,
            'stats' => $stats,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        $shareUrl = route('projects.show', $project);

        return view('freelancer.proposals.create', [
            'project' => $project,
            'proposal' => new Proposal(),
            'shareUrl' => $shareUrl,
            'units' => [
                'day' => 'Day',
                'week' => 'Week',
                'month' => 'Month',
                'year' => 'Year',
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $project_id)
    {
        $project = Project::findOrFail($project_id);
        if ($project->status !== 'open') {
            return redirect()->route('freelancer.proposals.index')
                ->with('error', 'You cannot submit a proposal to this project.');
        }
        $user = Auth::guard('web')->user();
        if ((int) $project->user_id === (int) $user->id) {
            return redirect()->route('projects.show', $project)
                ->with('error', 'You cannot submit a proposal to your own project.');
        }

        if ($user->proposals()->where('project_id', $project->id)->exists()) {
            return redirect()->route('freelancer.proposals.index')
                ->with('error', 'You already submitted a proposal to this project.');
        }

        $request->validate([
            'description' => ['required', 'string'],
            'cost' => ['required', 'numeric', 'min:1'],
            'duration' => ['required', 'int', 'min:1'],
            'duration_unit' => ['required', 'in:day,week,month,year'],
        ]);

        $proposal = $user->proposals()->create([
            'project_id' => $project_id,
            'description' => (string) $request->input('description'),
            'cost' => $request->input('cost'),
            'duration' => $request->input('duration'),
            'duration_unit' => $request->input('duration_unit'),
            'status' => 'pending',
        ]);

        $project->user->notify(new NewPropsalNotification($proposal, $user));

        return redirect()->route('projects.show', $project->id)
            ->with('success', 'Your proposal has been submitted.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
