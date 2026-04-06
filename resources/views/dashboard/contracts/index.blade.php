@extends('layouts.dashboard')

@section('title', 'Contracts')

@section('content')
    <x-flash-message />

    <div class="row">
        <div class="col-md-3 col-6">
            <div class="small-box bg-dark">
                <div class="inner">
                    <h3>{{ $stats['active'] }}</h3>
                    <p>Active Contracts</p>
                </div>
                <div class="icon"><i class="fas fa-briefcase"></i></div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $stats['completed'] }}</h3>
                    <p>Completed Contracts</p>
                </div>
                <div class="icon"><i class="fas fa-check-circle"></i></div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $stats['terminated'] }}</h3>
                    <p>Terminated Contracts</p>
                </div>
                <div class="icon"><i class="fas fa-times-circle"></i></div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>${{ number_format($stats['value'], 0) }}</h3>
                    <p>Total Contract Value</p>
                </div>
                <div class="icon"><i class="fas fa-dollar-sign"></i></div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ route('dashboard.contracts.index') }}" method="get" class="row">
                <div class="col-md-5">
                    <input type="text" name="q" class="form-control" value="{{ $query }}" placeholder="Search by project, client, or freelancer">
                </div>
                <div class="col-md-5">
                    <select name="status" class="form-control">
                        <option value="">All statuses</option>
                        <option value="active" @selected($status === 'active')>Active</option>
                        <option value="completed" @selected($status === 'completed')>Completed</option>
                        <option value="terminated" @selected($status === 'terminated')>Terminated</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary btn-block">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Project</th>
                        <th>Freelancer</th>
                        <th>Client</th>
                        <th>Status</th>
                        <th>Type</th>
                        <th>Cost</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($contracts as $contract)
                        <tr>
                            <td>{{ $contract->project->title ?? 'Deleted project' }}</td>
                            <td>{{ $contract->freelancer->name ?? 'Unknown' }}</td>
                            <td>{{ $contract->project->user->name ?? 'Deleted user' }}</td>
                            <td>{{ ucfirst($contract->status) }}</td>
                            <td>{{ ucfirst($contract->type) }}</td>
                            <td>${{ number_format($contract->cost, 0) }}</td>
                            <td class="text-right">
                                <a href="{{ route('dashboard.contracts.show', $contract) }}" class="btn btn-sm btn-outline-primary">Open</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No contracts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $contracts->links() }}</div>
@endsection
