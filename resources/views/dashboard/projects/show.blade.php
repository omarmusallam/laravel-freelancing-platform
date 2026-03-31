@extends('layouts.dashboard')

@section('title', 'Manage Project')

@section('content')
    <x-flash-message />

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dashboard.projects.update', $project) }}" method="post">
                        @csrf
                        @method('put')

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $project->title) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="desc">Description</label>
                            <textarea class="form-control" id="desc" name="desc" rows="6" required>{{ old('desc', $project->desc) }}</textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="type">Type</label>
                                <select class="form-control" id="type" name="type">
                                    <option value="fixed" @selected(old('type', $project->type) === 'fixed')>Fixed</option>
                                    <option value="hourly" @selected(old('type', $project->type) === 'hourly')>Hourly</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="open" @selected(old('status', $project->status) === 'open')>Open</option>
                                    <option value="in-progress" @selected(old('status', $project->status) === 'in-progress')>In Progress</option>
                                    <option value="closed" @selected(old('status', $project->status) === 'closed')>Closed</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="budget">Budget</label>
                                <input type="number" step="0.01" class="form-control" id="budget" name="budget" value="{{ old('budget', $project->budget) }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="category_id">Category</label>
                                <select class="form-control" id="category_id" name="category_id">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected((int) old('category_id', $project->category_id) === (int) $category->id)>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <button class="btn btn-primary">Save Project</button>
                        <a href="{{ route('projects.show', $project) }}" target="_blank" rel="noopener" class="btn btn-outline-secondary">View Public Page</a>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Project Snapshot</h3>
                </div>
                <div class="card-body">
                    <p><strong>Client:</strong> {{ $project->user->name ?? 'Deleted user' }}</p>
                    <p><strong>Category:</strong> {{ $project->category->parent->name ?? $project->category->name ?? 'No category' }}</p>
                    <p><strong>Tags:</strong> {{ $project->tags->pluck('name')->implode(', ') ?: 'No tags' }}</p>
                    <p><strong>Proposals:</strong> {{ $project->proposals->count() }}</p>
                    <p class="mb-0"><strong>Created:</strong> {{ $project->created_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
