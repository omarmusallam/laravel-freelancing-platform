@extends('layouts.dashboard')

@section('title', 'Manage Proposal')

@section('content')
    <x-flash-message />

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">Proposal Decision Desk</h5>
                        <p class="text-muted mb-0">Review the offer, then move it through the workflow with confidence.</p>
                    </div>
                    <div class="d-flex flex-wrap mt-2 mt-lg-0">
                        <a href="{{ route('dashboard.projects.show', $proposal->project_id) }}" class="btn btn-outline-primary mr-2 mb-2">Open Project</a>
                        <a href="{{ route('dashboard.contracts.index', ['q' => $proposal->project->title ?? '']) }}" class="btn btn-outline-dark mr-2 mb-2">Related Contracts</a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dashboard.proposals.update', $proposal) }}" method="post">
                        @csrf
                        @method('put')

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="6" required>{{ old('description', $proposal->description) }}</textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="cost">Cost</label>
                                <input type="number" step="0.01" class="form-control" id="cost" name="cost" value="{{ old('cost', $proposal->cost) }}" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="duration">Duration</label>
                                <input type="number" class="form-control" id="duration" name="duration" value="{{ old('duration', $proposal->duration) }}" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="duration_unit">Duration Unit</label>
                                <select class="form-control" id="duration_unit" name="duration_unit">
                                    @foreach (['day', 'week', 'month', 'year'] as $unit)
                                        <option value="{{ $unit }}" @selected(old('duration_unit', $proposal->duration_unit) === $unit)>{{ ucfirst($unit) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="pending" @selected(old('status', $proposal->status) === 'pending')>Pending</option>
                                    <option value="accepted" @selected(old('status', $proposal->status) === 'accepted')>Accepted</option>
                                    <option value="declined" @selected(old('status', $proposal->status) === 'declined')>Declined</option>
                                </select>
                            </div>
                        </div>

                        <button class="btn btn-primary">Save Proposal</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Proposal Context</h3>
                </div>
                <div class="card-body">
                    <p><strong>Freelancer:</strong> {{ $proposal->freelancer->name ?? 'Deleted user' }}</p>
                    <p><strong>Project:</strong> {{ $proposal->project->title ?? 'Deleted project' }}</p>
                    <p><strong>Client:</strong> {{ $proposal->project->user->name ?? 'Deleted user' }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($proposal->status) }}</p>
                    <p><strong>Commercial value:</strong> ${{ number_format($proposal->cost, 0) }}</p>
                    <p class="mb-0"><strong>Submitted:</strong> {{ $proposal->created_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
