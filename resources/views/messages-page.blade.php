<x-app-layout>
    <x-flash-message />

    <div class="messages-container margin-top-0">
        <div class="messages-container-inner">
            <div class="messages-inbox">
                <div class="messages-headline">
                    <div class="input-with-icon">
                        <input type="text" value="Contacts" readonly>
                        <i class="icon-material-outline-search"></i>
                    </div>
                </div>

                <ul>
                    @forelse ($contacts as $contact)
                        <li class="{{ optional($selectedContact)->id === $contact->id ? 'active-message' : '' }}">
                            <a href="{{ route('messages', ['recipient_id' => $contact->id]) }}">
                                <div class="message-avatar">
                                    <img src="{{ $contact->profile_photo_url }}" alt="{{ $contact->name }}" />
                                </div>
                                <div class="message-by">
                                    <div class="message-by-headline">
                                        <h5>{{ $contact->name }}</h5>
                                        <span>{{ optional($contact->updated_at)->diffForHumans() }}</span>
                                    </div>
                                    <p>{{ optional($contact->freelancer)->title ?: 'Client or freelancer account' }}</p>
                                </div>
                            </a>
                        </li>
                    @empty
                        <li>
                            <div class="message-by" style="padding: 20px;">
                                <p>No contacts available yet.</p>
                            </div>
                        </li>
                    @endforelse
                </ul>
            </div>

            <div class="message-content">
                <div class="messages-headline">
                    <h4>{{ $selectedContact?->name ?? 'Choose a conversation' }}</h4>
                </div>

                <div class="message-content-inner">
                    @if ($selectedContact)
                        @forelse ($messages as $message)
                            <div class="message-bubble {{ $message->sender_id === auth()->id() ? 'me' : '' }}">
                                <div class="message-bubble-inner">
                                    <div class="message-avatar">
                                        <img src="{{ $message->sender->profile_photo_url }}" alt="{{ $message->sender->name }}" />
                                    </div>
                                    <div class="message-text">
                                        <p>{{ $message->message }}</p>
                                        <small>{{ $message->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        @empty
                            <div class="message-time-sign">
                                <span>No messages yet. Start the conversation.</span>
                            </div>
                        @endforelse
                    @else
                        <div class="message-time-sign">
                            <span>Select a contact to open the conversation.</span>
                        </div>
                    @endif
                </div>

                @if ($selectedContact)
                    <form action="{{ route('messages') }}" method="post">
                        <div class="message-reply">
                            @csrf
                            <input type="hidden" name="recipient_id" value="{{ $selectedContact->id }}">
                            <textarea cols="1" rows="1" name="message" placeholder="Your Message" data-autoresize></textarea>
                            <button class="button ripple-effect" type="submit">Send</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
