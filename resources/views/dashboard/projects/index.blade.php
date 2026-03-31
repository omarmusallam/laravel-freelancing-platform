@extends('layouts.dashboard')

@section('title', 'Projects')

@section('content')
    <x-flash-message />

    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ route('dashboard.projects.index') }}" method="get" class="row">
                <div class="col-md-7">
                    <input type="text" name="q" class="form-control" placeholder="Search projects" value="{{ $query }}">
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
                        <th>Status</th>
                        <th>Budget</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($projects as $project)
                        <tr>
                            <td><input type="checkbox" class="bulk-project" name="project_ids[]" value="{{ $project->id }}"></td>
                            <td>{{ $project->title }}</td>
                            <td>{{ $project->user->name ?? 'Deleted user' }}</td>
                            <td>{{ $project->category->name ?? 'No category' }}</td>
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
                    @endforeach
                </tbody>
                </table>
            </div>
        </form>
        </div>
    </div>

    {{ $projects->links() }}
@endsection
