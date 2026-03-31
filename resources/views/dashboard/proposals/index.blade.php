@extends('layouts.dashboard')

@section('title', 'Proposals')

@section('content')
    <x-flash-message />

    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ route('dashboard.proposals.index') }}" method="get" class="row">
                <div class="col-md-10">
                    <select name="status" class="form-control">
                        <option value="">All statuses</option>
                        <option value="pending" @selected($status === 'pending')>Pending</option>
                        <option value="accepted" @selected($status === 'accepted')>Accepted</option>
                        <option value="declined" @selected($status === 'declined')>Declined</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary btn-block">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <form action="{{ route('dashboard.proposals.bulk') }}" method="post">
            @csrf
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <select name="action" class="form-control form-control-sm mr-2" style="width: 220px;">
                        <option value="pending">Mark as pending</option>
                        <option value="accepted">Mark as accepted</option>
                        <option value="declined">Mark as declined</option>
                        <option value="delete">Delete selected</option>
                    </select>
                    <button class="btn btn-sm btn-outline-primary" onclick="return confirm('Apply bulk action to selected proposals?')">Apply</button>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 40px;"><input type="checkbox" onclick="document.querySelectorAll('.bulk-proposal').forEach((item) => item.checked = this.checked)"></th>
                        <th>Freelancer</th>
                        <th>Project</th>
                        <th>Cost</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proposals as $proposal)
                        <tr>
                            <td><input type="checkbox" class="bulk-proposal" name="proposal_ids[]" value="{{ $proposal->id }}"></td>
                            <td>{{ $proposal->freelancer->name ?? 'Deleted user' }}</td>
                            <td>{{ $proposal->project->title ?? 'Deleted project' }}</td>
                            <td>${{ number_format($proposal->cost, 0) }}</td>
                            <td>{{ $proposal->duration }} {{ $proposal->duration_unit }}</td>
                            <td>{{ ucfirst($proposal->status) }}</td>
                            <td class="text-right">
                                <a href="{{ route('dashboard.proposals.show', $proposal) }}" class="btn btn-sm btn-outline-primary">Open</a>
                                <form action="{{ route('dashboard.proposals.destroy', $proposal) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this proposal?')">Delete</button>
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

    {{ $proposals->links() }}
@endsection
