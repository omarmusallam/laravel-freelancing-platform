@extends('layouts.dashboard')

@section('title', 'Create Admin')

@section('content')
    <x-flash-message />

    <div class="card">
        <div class="card-body">
            <form action="{{ route('dashboard.admins.store') }}" method="post">
                @include('dashboard.admins._form')
            </form>
        </div>
    </div>
@endsection
