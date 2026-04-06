<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function index(Request $request)
    {
        $query = trim((string) $request->input('q', ''));
        $read = $request->input('read');

        $messages = Message::with(['sender', 'recipient'])
            ->when($query !== '', function ($builder) use ($query) {
                $builder->where(function ($messageQuery) use ($query) {
                    $messageQuery->where('message', 'like', '%' . $query . '%')
                        ->orWhereHas('sender', function ($userQuery) use ($query) {
                            $userQuery->where('name', 'like', '%' . $query . '%')
                                ->orWhere('email', 'like', '%' . $query . '%');
                        })
                        ->orWhereHas('recipient', function ($userQuery) use ($query) {
                            $userQuery->where('name', 'like', '%' . $query . '%')
                                ->orWhere('email', 'like', '%' . $query . '%');
                        });
                });
            })
            ->when($read === 'unread', function ($builder) {
                $builder->whereNull('read_at');
            })
            ->when($read === 'read', function ($builder) {
                $builder->whereNotNull('read_at');
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $stats = [
            'total' => Message::count(),
            'unread' => Message::whereNull('read_at')->count(),
            'read' => Message::whereNotNull('read_at')->count(),
        ];

        return view('dashboard.messages.index', [
            'messages' => $messages,
            'query' => $query,
            'read' => $read,
            'stats' => $stats,
        ]);
    }

    public function show(Message $message)
    {
        if (!$message->read_at) {
            $message->update(['read_at' => now()]);
        }

        return view('dashboard.messages.show', [
            'message' => $message->load(['sender.freelancer', 'recipient.freelancer']),
        ]);
    }
}
