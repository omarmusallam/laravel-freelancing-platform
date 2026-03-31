@extends('layouts.dashboard')

@section('title')
    Admins <small><a href="{{ route('dashboard.admins.create') }}" class="btn btn-sm btn-primary">Add Admin</a></small>
@endsection

@section('content')
    <x-flash-message />

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Level</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admins as $admin)
                        <tr>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ ucfirst($admin->status) }}</td>
                            <td>{{ $admin->super_admin ? 'Super Admin' : 'Admin' }}</td>
                            <td class="text-right">
                                <a href="{{ route('dashboard.admins.edit', $admin) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('dashboard.admins.destroy', $admin) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this admin account?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{ $admins->links() }}
@endsection
