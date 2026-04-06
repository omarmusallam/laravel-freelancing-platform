<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Services\ContractWorkflowService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContractsController extends Controller
{
    public function __construct(protected ContractWorkflowService $workflow)
    {
    }

    public function index(Request $request)
    {
        $status = $request->input('status');
        $query = trim((string) $request->input('q', ''));

        $contracts = Contract::with(['project', 'freelancer', 'proposal'])
            ->when($query !== '', function ($builder) use ($query) {
                $builder->where(function ($contractQuery) use ($query) {
                    $contractQuery
                        ->whereHas('project', function ($projectQuery) use ($query) {
                            $projectQuery->where('title', 'like', '%' . $query . '%');
                        })
                        ->orWhereHas('freelancer', function ($userQuery) use ($query) {
                            $userQuery->where('name', 'like', '%' . $query . '%')
                                ->orWhere('email', 'like', '%' . $query . '%');
                        })
                        ->orWhereHas('project.user', function ($userQuery) use ($query) {
                            $userQuery->where('name', 'like', '%' . $query . '%')
                                ->orWhere('email', 'like', '%' . $query . '%');
                        });
                });
            })
            ->when(in_array($status, ['active', 'completed', 'terminated'], true), function ($builder) use ($status) {
                $builder->where('status', $status);
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $stats = [
            'active' => Contract::where('status', 'active')->count(),
            'completed' => Contract::where('status', 'completed')->count(),
            'terminated' => Contract::where('status', 'terminated')->count(),
            'value' => Contract::sum('cost'),
        ];

        return view('dashboard.contracts.index', [
            'contracts' => $contracts,
            'status' => $status,
            'query' => $query,
            'stats' => $stats,
        ]);
    }

    public function show(Contract $contract)
    {
        return view('dashboard.contracts.show', [
            'contract' => $contract->load(['project.user', 'freelancer.freelancer', 'proposal']),
        ]);
    }

    public function update(Request $request, Contract $contract)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['active', 'completed', 'terminated'])],
            'cost' => ['required', 'numeric', 'min:0'],
            'hours' => ['nullable', 'numeric', 'min:0'],
            'start_on' => ['required', 'date'],
            'end_on' => ['required', 'date', 'after_or_equal:start_on'],
            'completed_on' => ['nullable', 'date'],
        ]);

        if ($data['status'] === 'completed' && empty($data['completed_on'])) {
            $data['completed_on'] = now()->toDateString();
        }

        if ($data['status'] !== 'completed') {
            $data['completed_on'] = null;
        }

        $this->workflow->sync($contract, $data);

        return redirect()
            ->route('dashboard.contracts.show', $contract)
            ->with('success', 'Contract updated successfully.');
    }
}
