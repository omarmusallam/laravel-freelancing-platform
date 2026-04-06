@extends('layouts.dashboard')

@section('title', 'Messages')

@section('content')
    <x-flash-message />

    <div class="row">
        <div class="col-md-4 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $stats['total'] }}</h3>
                    <p>Total Messages</p>
                </div>
                <div class="icon"><i class="fas fa-comments"></i></div>
            </div>
        </div>
        <div class="col-md-4 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stats['unread'] }}</h3>
                    <p>Unread Messages</p>
                </div>
                <div class="icon"><i class="fas fa-envelope"></i></div>
            </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $stats['read'] }}</h3>
                    <p>Reviewed Messages</p>
                </div>
                <div class="icon"><i class="fas fa-envelope-open"></i></div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ route('dashboard.messages.index') }}" method="get" class="row">
                <div class="col-md-6">
                    <input type="text" name="q" class="form-control" value="{{ $query }}" placeholder="Search by content, sender, or recipient">
                </div>
                <div class="col-md-4">
                    <select name="read" class="form-control">
                        <option value="">All messages</option>
                        <option value="unread" @selected($read === 'unread')>Unread only</option>
                        <option value="read" @selected($read === 'read')>Read only</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary btn-block">Search</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Sender</th>
                        <th>Recipient</th>
                        <th>Preview</th>
                        <th>Read</th>
                        <th>Sent</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($messages as $message)
                        <tr>
                            <td>{{ $message->sender->email ?? 'Deleted user' }}</td>
                            <td>{{ $message->recipient->email ?? 'Deleted user' }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($message->message, 70) }}</td>
                            <td>
                                @if ($message->read_at)
                                    <span class="badge badge-success">Read</span>
                                @else
                                    <span class="badge badge-warning">Unread</span>
                                @endif
                            </td>
                            <td>{{ $message->created_at->diffForHumans() }}</td>
                            <td class="text-right">
                                <a href="{{ route('dashboard.messages.show', $message) }}" class="btn btn-sm btn-outline-primary">Open</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No messages found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $messages->links() }}</div>
@endsection
