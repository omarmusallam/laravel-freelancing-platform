<?php

namespace App\Http\Controllers;

use App\Events\MessageCreated;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = $request->user();

        $recipientId = $request->input('recipient_id');
        $recipientId = is_numeric($recipientId) ? (int) $recipientId : null;

        $contactIds = Message::query()
            ->select('sender_id as contact_id')
            ->where('recipient_id', $user->id)
            ->union(
                Message::query()
                    ->select('recipient_id as contact_id')
                    ->where('sender_id', $user->id)
            )
            ->pluck('contact_id')
            ->filter(fn ($id) => (int) $id !== (int) $user->id)
            ->unique()
            ->values();

        if ($recipientId && !$contactIds->contains($recipientId)) {
            $contactIds->push($recipientId);
        }

        $contacts = User::query()
            ->whereIn('id', $contactIds->all())
            ->whereKeyNot($user->id)
            ->orderBy('name')
            ->get();

        $selectedContact = $contacts->firstWhere('id', $recipientId) ?: $contacts->first();

        $messages = collect();
        if ($selectedContact) {
            $messages = Message::query()
                ->with(['sender', 'recipient'])
                ->where(function ($query) use ($user, $selectedContact) {
                    $query->where('sender_id', $user->id)
                        ->where('recipient_id', $selectedContact->id);
                })
                ->orWhere(function ($query) use ($user, $selectedContact) {
                    $query->where('sender_id', $selectedContact->id)
                        ->where('recipient_id', $user->id);
                })
                ->latest()
                ->take(50)
                ->get()
                ->reverse()
                ->values();
        }

        return view('messages-page', [
            'contacts' => $contacts,
            'selectedContact' => $selectedContact,
            'messages' => $messages,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'message' => ['required', 'string'],
            'recipient_id' => ['required', 'int', 'exists:users,id', 'different:' . $request->user()->id]
        ]);

        $message = Message::create([
            'sender_id' => $request->user()->id,
            'recipient_id' => $request->post('recipient_id'),
            'message' => $request->post('message'),
        ]);

        event(new MessageCreated($message));

        return redirect()
            ->route('messages', ['recipient_id' => $request->post('recipient_id')])
            ->with('success', 'Message sent successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
