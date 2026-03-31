<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProposalsController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');

        $proposals = Proposal::with(['project', 'freelancer'])
            ->when(in_array($status, ['pending', 'accepted', 'declined'], true), function ($builder) use ($status) {
                $builder->where('status', $status);
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('dashboard.proposals.index', [
            'proposals' => $proposals,
            'status' => $status,
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

        $proposal->update($data);

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

        $proposals = Proposal::whereIn('id', $data['proposal_ids']);

        if ($data['action'] === 'delete') {
            $proposals->delete();
        } else {
            $proposals->update(['status' => $data['action']]);
        }

        return redirect()
            ->route('dashboard.proposals.index')
            ->with('success', 'Bulk proposal action completed successfully.');
    }

    public function destroy(Proposal $proposal)
    {
        $proposal->delete();

        return redirect()
            ->route('dashboard.proposals.index')
            ->with('success', 'Proposal deleted successfully.');
    }
}
