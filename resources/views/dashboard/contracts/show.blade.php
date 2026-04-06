@extends('layouts.dashboard')

@section('title', 'Manage Contract')

@section('content')
    <x-flash-message />

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">Contract Control Panel</h5>
                        <p class="text-muted mb-0">Synchronize contract status with project delivery and proposal outcome.</p>
                    </div>
                    <div class="d-flex flex-wrap mt-2 mt-lg-0">
                        <a href="{{ route('dashboard.projects.show', $contract->project_id) }}" class="btn btn-outline-primary mr-2 mb-2">Open Project</a>
                        @if ($contract->proposal_id)
                            <a href="{{ route('dashboard.proposals.show', $contract->proposal_id) }}" class="btn btn-outline-success mr-2 mb-2">Open Proposal</a>
                        @endif
                        <a href="{{ route('dashboard.payments.index', ['q' => $contract->project->user->email ?? '']) }}" class="btn btn-outline-info mb-2">Check Payments</a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dashboard.contracts.update', $contract) }}" method="post">
                        @csrf
                        @method('put')

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="active" @selected(old('status', $contract->status) === 'active')>Active</option>
                                    <option value="completed" @selected(old('status', $contract->status) === 'completed')>Completed</option>
                                    <option value="terminated" @selected(old('status', $contract->status) === 'terminated')>Terminated</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="cost">Cost</label>
                                <input type="number" step="0.01" class="form-control" id="cost" name="cost" value="{{ old('cost', $contract->cost) }}" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="hours">Hours</label>
                                <input type="number" step="0.01" class="form-control" id="hours" name="hours" value="{{ old('hours', $contract->hours) }}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="start_on">Start date</label>
                                <input type="date" class="form-control" id="start_on" name="start_on" value="{{ old('start_on', optional($contract->start_on)->toDateString()) }}" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="end_on">End date</label>
                                <input type="date" class="form-control" id="end_on" name="end_on" value="{{ old('end_on', optional($contract->end_on)->toDateString()) }}" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="completed_on">Completed on</label>
                                <input type="date" class="form-control" id="completed_on" name="completed_on" value="{{ old('completed_on', optional($contract->completed_on)->toDateString()) }}">
                            </div>
                        </div>

                        <button class="btn btn-primary">Save Contract</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Contract Summary</h3>
                </div>
                <div class="card-body">
                    <p><strong>Project:</strong> {{ $contract->project->title ?? 'Deleted project' }}</p>
                    <p><strong>Client:</strong> {{ $contract->project->user->name ?? 'Deleted user' }}</p>
                    <p><strong>Freelancer:</strong> {{ $contract->freelancer->name ?? 'Unknown' }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($contract->status) }}</p>
                    <p><strong>Type:</strong> {{ ucfirst($contract->type) }}</p>
                    <p><strong>Proposal:</strong> {{ $contract->proposal->description ? \Illuminate\Support\Str::limit($contract->proposal->description, 80) : 'No linked proposal' }}</p>
                    <p class="mb-0"><strong>Created:</strong> {{ $contract->created_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
