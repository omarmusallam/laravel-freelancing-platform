<?php

namespace Tests\Feature;

use App\Events\MessageCreated;
use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class MessagesFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_messages_page_requires_authentication()
    {
        $this->get(route('messages'))
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_send_a_message()
    {
        Event::fake([MessageCreated::class]);

        $sender = User::factory()->create();
        $recipient = User::factory()->create();

        $this->actingAs($sender)
            ->post(route('messages'), [
                'recipient_id' => $recipient->id,
                'message' => 'Hello from the test suite.',
            ])
            ->assertRedirect(route('messages', ['recipient_id' => $recipient->id]));

        $this->assertDatabaseHas('messages', [
            'sender_id' => $sender->id,
            'recipient_id' => $recipient->id,
            'message' => 'Hello from the test suite.',
        ]);

        Event::assertDispatched(MessageCreated::class);

        $this->actingAs($sender)
            ->get(route('messages', ['recipient_id' => $recipient->id]))
            ->assertOk()
            ->assertSee('Hello from the test suite.');
    }
}
