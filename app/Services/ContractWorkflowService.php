<?php

namespace App\Services;

use App\Models\Contract;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ContractWorkflowService
{
    public function sync(Contract $contract, array $attributes): Contract
    {
        return DB::transaction(function () use ($contract, $attributes) {
            $contract->refresh();
            $contract->update($attributes);

            if ($contract->status === 'completed' && !$contract->completed_on) {
                $contract->forceFill([
                    'completed_on' => Carbon::today()->toDateString(),
                ])->save();
            }

            if ($contract->status === 'active' && $contract->completed_on) {
                $contract->forceFill([
                    'completed_on' => null,
                ])->save();
            }

            $this->syncProposalStatus($contract);
            $this->syncProjectStatus($contract);

            return $contract->fresh(['project', 'proposal', 'freelancer']);
        });
    }

    protected function syncProposalStatus(Contract $contract): void
    {
        if (!$contract->proposal_id) {
            return;
        }

        $proposal = $contract->proposal()->first();

        if (!$proposal) {
            return;
        }

        $proposal->update([
            'status' => in_array($contract->status, ['active', 'completed'], true) ? 'accepted' : 'declined',
        ]);
    }

    protected function syncProjectStatus(Contract $contract): void
    {
        $project = $contract->project()->withoutGlobalScopes()->first();

        if (!$project) {
            return;
        }

        $projectContracts = $project->contracts()->get();

        if ($projectContracts->contains('status', 'completed')) {
            $project->update(['status' => 'closed']);

            return;
        }

        if ($projectContracts->contains('status', 'active')) {
            $project->update(['status' => 'in-progress']);

            return;
        }

        $project->update(['status' => 'open']);
    }
}
