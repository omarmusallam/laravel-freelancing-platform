@extends('layouts.dashboard')

@section('title', 'Edit Admin')

@section('content')
    <x-flash-message />

    <div class="card">
        <div class="card-body">
            <form action="{{ route('dashboard.admins.update', $admin) }}" method="post">
                @method('put')
                @include('dashboard.admins._form')
            </form>
        </div>
    </div>
@endsection
