@extends('layouts.dashboard')

@section('title', 'Manage User')

@section('content')
    <x-flash-message />

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dashboard.users.update', $user) }}" method="post">
                        @csrf
                        @method('put')

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="form-group">
                            <label>Roles</label>
                            @foreach ($roles as $role)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="role-{{ $role->id }}" name="roles[]" value="{{ $role->id }}"
                                        @checked(in_array($role->id, old('roles', $user->roles->pluck('id')->all()), true))>
                                    <label class="form-check-label" for="role-{{ $role->id }}">{{ $role->name }}</label>
                                </div>
                            @endforeach
                        </div>

                        <button class="btn btn-primary">Save User</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Profile Summary</h3>
                </div>
                <div class="card-body">
                    <p><strong>Projects:</strong> {{ $user->projects()->count() }}</p>
                    <p><strong>Proposals:</strong> {{ $user->proposals()->count() }}</p>
                    <p><strong>Freelancer title:</strong> {{ $user->freelancer->title ?: 'Not set' }}</p>
                    <p class="mb-0"><strong>Country:</strong> {{ $user->freelancer->country ?: 'Not set' }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
