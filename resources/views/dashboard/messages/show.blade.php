@extends('layouts.dashboard')

@section('title', 'Message Review')

@section('content')
    <x-flash-message />

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">Conversation Review</h5>
                        <p class="text-muted mb-0">Inspect sensitive conversations quickly and route follow-up to the right queue.</p>
                    </div>
                    <div class="d-flex flex-wrap mt-2 mt-lg-0">
                        <a href="{{ route('dashboard.messages.index', ['q' => $message->sender->email ?? '']) }}" class="btn btn-outline-secondary mr-2 mb-2">More From Sender</a>
                        <a href="{{ route('dashboard.messages.index', ['read' => 'unread']) }}" class="btn btn-outline-warning mb-2">Unread Queue</a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Conversation Message</h3>
                </div>
                <div class="card-body">
                    <div class="border rounded p-3 bg-light">
                        {!! nl2br(e($message->message)) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Message Snapshot</h3>
                </div>
                <div class="card-body">
                    <p><strong>Sender:</strong> {{ $message->sender->name ?? 'Deleted user' }}</p>
                    <p><strong>Sender email:</strong> {{ $message->sender->email ?? 'N/A' }}</p>
                    <p><strong>Recipient:</strong> {{ $message->recipient->name ?? 'Deleted user' }}</p>
                    <p><strong>Recipient email:</strong> {{ $message->recipient->email ?? 'N/A' }}</p>
                    <p><strong>Read at:</strong> {{ $message->read_at ? $message->read_at->format('Y-m-d H:i') : 'Unread' }}</p>
                    <p class="mb-0"><strong>Sent at:</strong> {{ $message->created_at->format('Y-m-d H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
