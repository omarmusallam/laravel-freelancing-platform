<?php

namespace App\Services;

use App\Models\Contract;
use App\Models\Proposal;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProposalWorkflowService
{
    public function applyDecision(Proposal $proposal, array $attributes): Proposal
    {
        return DB::transaction(function () use ($proposal, $attributes) {
            $proposal->refresh();

            $status = $attributes['status'];
            $proposal->update($attributes);

            if ($status === 'accepted') {
                $this->acceptProposal($proposal);
            } else {
                $this->releaseAcceptedProposal($proposal);
            }

            return $proposal->fresh(['project', 'freelancer', 'contract']);
        });
    }

    protected function acceptProposal(Proposal $proposal): void
    {
        $project = $proposal->project()->withoutGlobalScopes()->firstOrFail();

        $project->proposals()
            ->whereKeyNot($proposal->id)
            ->where('status', 'accepted')
            ->update(['status' => 'declined']);

        $project->proposals()
            ->whereKeyNot($proposal->id)
            ->where('status', 'pending')
            ->update(['status' => 'declined']);

        Contract::where('project_id', $project->id)
            ->where('proposal_id', '!=', $proposal->id)
            ->where('status', 'active')
            ->update([
                'status' => 'terminated',
                'completed_on' => Carbon::today()->toDateString(),
            ]);

        Contract::updateOrCreate(
            ['proposal_id' => $proposal->id],
            [
                'freelancer_id' => $proposal->freelancer_id,
                'project_id' => $project->id,
                'cost' => $proposal->cost,
                'type' => $project->type,
                'start_on' => Carbon::today()->toDateString(),
                'end_on' => $this->calculateEndDate($proposal),
                'completed_on' => null,
                'hours' => $project->type === 'hourly' ? ($proposal->duration * 5) : 0,
                'status' => 'active',
            ]
        );

        if ($project->status !== 'closed') {
            $project->update(['status' => 'in-progress']);
        }
    }

    protected function releaseAcceptedProposal(Proposal $proposal): void
    {
        $project = $proposal->project()->withoutGlobalScopes()->firstOrFail();

        Contract::where('proposal_id', $proposal->id)
            ->where('status', 'active')
            ->update([
                'status' => 'terminated',
                'completed_on' => Carbon::today()->toDateString(),
            ]);

        $hasAcceptedProposal = $project->proposals()
            ->where('status', 'accepted')
            ->exists();

        if (!$hasAcceptedProposal && $project->status === 'in-progress') {
            $project->update(['status' => 'open']);
        }
    }

    protected function calculateEndDate(Proposal $proposal): string
    {
        $start = Carbon::today();

        switch ($proposal->duration_unit) {
            case 'day':
                return $start->copy()->addDays($proposal->duration)->toDateString();
            case 'week':
                return $start->copy()->addWeeks($proposal->duration)->toDateString();
            case 'month':
                return $start->copy()->addMonths($proposal->duration)->toDateString();
            case 'year':
                return $start->copy()->addYears($proposal->duration)->toDateString();
            default:
                return $start->copy()->addWeeks(2)->toDateString();
        }
    }
}
