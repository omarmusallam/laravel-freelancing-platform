@extends('layouts.dashboard')

@section('title', 'Users')

@section('content')
    <x-flash-message />

    <div class="row">
        <div class="col-md-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $stats['users'] }}</h3>
                    <p>Total Users</p>
                </div>
                <div class="icon"><i class="fas fa-users"></i></div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $stats['clients'] }}</h3>
                    <p>Clients</p>
                </div>
                <div class="icon"><i class="fas fa-user-tie"></i></div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stats['freelancers'] }}</h3>
                    <p>Freelancers</p>
                </div>
                <div class="icon"><i class="fas fa-user-cog"></i></div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="small-box bg-dark">
                <div class="inner">
                    <h3>{{ $stats['with_contracts'] }}</h3>
                    <p>Users With Contracts</p>
                </div>
                <div class="icon"><i class="fas fa-file-contract"></i></div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ route('dashboard.users.index') }}" method="get" class="row">
                <div class="col-md-8">
                    <input type="text" name="q" class="form-control" placeholder="Search by name or email" value="{{ $query }}">
                </div>
                <div class="col-md-2">
                    <select name="role" class="form-control">
                        <option value="">All roles</option>
                        <option value="client" @selected($role === 'client')>Client</option>
                        <option value="freelancer" @selected($role === 'freelancer')>Freelancer</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary btn-block">Search</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <form action="{{ route('dashboard.users.bulk') }}" method="post">
            @csrf
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <select name="action" class="form-control form-control-sm mr-2" style="width: 180px;">
                        <option value="delete">Delete selected</option>
                    </select>
                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Apply bulk action to selected users?')">Apply</button>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 40px;"><input type="checkbox" onclick="document.querySelectorAll('.bulk-user').forEach((item) => item.checked = this.checked)"></th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Projects</th>
                        <th>Proposals</th>
                        <th>Contracts</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td><input type="checkbox" class="bulk-user" name="user_ids[]" value="{{ $user->id }}"></td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->roles->pluck('name')->implode(', ') ?: 'No roles' }}</td>
                            <td>{{ $user->projects_count }}</td>
                            <td>{{ $user->proposals_count }}</td>
                            <td>{{ $user->contracts_count }}</td>
                            <td class="text-right">
                                <a href="{{ route('dashboard.users.edit', $user) }}" class="btn btn-sm btn-outline-primary">Manage</a>
                                <form action="{{ route('dashboard.users.destroy', $user) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this user account?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
                </table>
            </div>
        </form>
        </div>
    </div>

    {{ $users->links() }}
@endsection
