@extends('layouts.dashboard')

@section('title', 'Projects')

@section('content')
    <x-flash-message />

    <div class="row">
        <div class="col-md-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $stats['open'] }}</h3>
                    <p>Open Projects</p>
                </div>
                <div class="icon"><i class="fas fa-folder-open"></i></div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stats['in_progress'] }}</h3>
                    <p>In Progress</p>
                </div>
                <div class="icon"><i class="fas fa-spinner"></i></div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $stats['closed'] }}</h3>
                    <p>Closed Projects</p>
                </div>
                <div class="icon"><i class="fas fa-lock"></i></div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>${{ number_format($stats['budget'], 0) }}</h3>
                    <p>Budget Volume</p>
                </div>
                <div class="icon"><i class="fas fa-dollar-sign"></i></div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ route('dashboard.projects.index') }}" method="get" class="row">
                <div class="col-md-5">
                    <input type="text" name="q" class="form-control" placeholder="Search project, description, or client" value="{{ $query }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-control">
                        <option value="">All statuses</option>
                        <option value="open" @selected($status === 'open')>Open</option>
                        <option value="in-progress" @selected($status === 'in-progress')>In Progress</option>
                        <option value="closed" @selected($status === 'closed')>Closed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="type" class="form-control">
                        <option value="">All types</option>
                        <option value="fixed" @selected($type === 'fixed')>Fixed</option>
                        <option value="hourly" @selected($type === 'hourly')>Hourly</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary btn-block">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <form action="{{ route('dashboard.projects.bulk') }}" method="post">
            @csrf
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <select name="action" class="form-control form-control-sm mr-2" style="width: 220px;">
                        <option value="open">Mark as open</option>
                        <option value="in-progress">Mark as in progress</option>
                        <option value="closed">Mark as closed</option>
                        <option value="delete">Delete selected</option>
                    </select>
                    <button class="btn btn-sm btn-outline-primary" onclick="return confirm('Apply bulk action to selected projects?')">Apply</button>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 40px;"><input type="checkbox" onclick="document.querySelectorAll('.bulk-project').forEach((item) => item.checked = this.checked)"></th>
                        <th>Project</th>
                        <th>Client</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Budget</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($projects as $project)
                        <tr>
                            <td><input type="checkbox" class="bulk-project" name="project_ids[]" value="{{ $project->id }}"></td>
                            <td>{{ $project->title }}</td>
                            <td>{{ $project->user->name ?? 'Deleted user' }}</td>
                            <td>{{ $project->category->name ?? 'No category' }}</td>
                            <td>{{ ucfirst($project->type) }}</td>
                            <td>{{ ucfirst($project->status) }}</td>
                            <td>${{ number_format($project->budget ?? 0, 0) }}</td>
                            <td class="text-right">
                                <a href="{{ route('dashboard.projects.show', $project) }}" class="btn btn-sm btn-outline-primary">Open</a>
                                <form action="{{ route('dashboard.projects.destroy', $project) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this project?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No projects found.</td>
                        </tr>
                    @endforelse
                </tbody>
                </table>
            </div>
        </form>
        </div>
    </div>

    {{ $projects->links() }}
@endsection
