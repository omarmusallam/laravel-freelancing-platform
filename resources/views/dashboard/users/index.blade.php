@extends('layouts.dashboard')

@section('title', 'Users')

@section('content')
    <x-flash-message />

    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ route('dashboard.users.index') }}" method="get" class="row">
                <div class="col-md-10">
                    <input type="text" name="q" class="form-control" placeholder="Search by name or email" value="{{ $query }}">
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
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td><input type="checkbox" class="bulk-user" name="user_ids[]" value="{{ $user->id }}"></td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->roles->pluck('name')->implode(', ') ?: 'No roles' }}</td>
                            <td>{{ $user->projects->count() }}</td>
                            <td>{{ $user->proposals->count() }}</td>
                            <td class="text-right">
                                <a href="{{ route('dashboard.users.edit', $user) }}" class="btn btn-sm btn-outline-primary">Manage</a>
                                <form action="{{ route('dashboard.users.destroy', $user) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this user account?')">Delete</button>
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

    {{ $users->links() }}
@endsection
