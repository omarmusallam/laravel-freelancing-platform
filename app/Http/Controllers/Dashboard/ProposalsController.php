<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use App\Services\ProposalWorkflowService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProposalsController extends Controller
{
    public function __construct(protected ProposalWorkflowService $workflow)
    {
    }

    public function index(Request $request)
    {
        $status = $request->input('status');
        $query = trim((string) $request->input('q', ''));

        $proposals = Proposal::with(['project', 'freelancer'])
            ->when($query !== '', function ($builder) use ($query) {
                $builder->where(function ($proposalQuery) use ($query) {
                    $proposalQuery->where('description', 'like', '%' . $query . '%')
                        ->orWhereHas('freelancer', function ($userQuery) use ($query) {
                            $userQuery->where('name', 'like', '%' . $query . '%')
                                ->orWhere('email', 'like', '%' . $query . '%');
                        })
                        ->orWhereHas('project', function ($projectQuery) use ($query) {
                            $projectQuery->where('title', 'like', '%' . $query . '%');
                        });
                });
            })
            ->when(in_array($status, ['pending', 'accepted', 'declined'], true), function ($builder) use ($status) {
                $builder->where('status', $status);
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $stats = [
            'pending' => Proposal::where('status', 'pending')->count(),
            'accepted' => Proposal::where('status', 'accepted')->count(),
            'declined' => Proposal::where('status', 'declined')->count(),
            'value' => Proposal::sum('cost'),
        ];

        return view('dashboard.proposals.index', [
            'proposals' => $proposals,
            'status' => $status,
            'query' => $query,
            'stats' => $stats,
        ]);
    }

    public function show(Proposal $proposal)
    {
        return view('dashboard.proposals.show', [
            'proposal' => $proposal->load(['project.user', 'freelancer']),
        ]);
    }

    public function update(Request $request, Proposal $proposal)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['pending', 'accepted', 'declined'])],
            'description' => ['required', 'string'],
            'cost' => ['required', 'numeric', 'min:1'],
            'duration' => ['required', 'integer', 'min:1'],
            'duration_unit' => ['required', Rule::in(['day', 'week', 'month', 'year'])],
        ]);

        $this->workflow->applyDecision($proposal, $data);

        return redirect()
            ->route('dashboard.proposals.show', $proposal)
            ->with('success', 'Proposal updated successfully.');
    }

    public function bulk(Request $request)
    {
        $data = $request->validate([
            'proposal_ids' => ['required', 'array'],
            'proposal_ids.*' => ['integer', 'exists:proposals,id'],
            'action' => ['required', Rule::in(['pending', 'accepted', 'declined', 'delete'])],
        ]);

        if ($data['action'] === 'delete') {
            Proposal::whereIn('id', $data['proposal_ids'])
                ->get()
                ->each(function (Proposal $proposal) {
                    $proposal->contract()->delete();
                    $proposal->delete();
                });
        } else {
            Proposal::whereIn('id', $data['proposal_ids'])
                ->get()
                ->each(function (Proposal $proposal) use ($data) {
                    $payload = [
                        'description' => $proposal->description,
                        'cost' => $proposal->cost,
                        'duration' => $proposal->duration,
                        'duration_unit' => $proposal->duration_unit,
                        'status' => $data['action'],
                    ];

                    $this->workflow->applyDecision($proposal, $payload);
                });
        }

        return redirect()
            ->route('dashboard.proposals.index')
            ->with('success', 'Bulk proposal action completed successfully.');
    }

    public function destroy(Proposal $proposal)
    {
        $proposal->contract()->delete();
        $proposal->delete();

        return redirect()
            ->route('dashboard.proposals.index')
            ->with('success', 'Proposal deleted successfully.');
    }
}
