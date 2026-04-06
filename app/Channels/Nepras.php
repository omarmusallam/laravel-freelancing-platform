<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class Nepras
{
    protected $baseUrl = 'https://www.nsms.ps';

    public function send($notifiable, Notification $notification)
    {
        $recipient = trim((string) $notifiable->routeNotificationForNepras($notification));
        $username = config('services.nepras.user');
        $password = config('services.nepras.pass');
        $sender = config('services.nepras.sender');

        if ($recipient === '' || blank($username) || blank($password) || blank($sender)) {
            Log::warning('Skipping Nepras notification because the channel is not fully configured.', [
                'recipient' => $recipient,
                'notification' => get_class($notification),
            ]);

            return;
        }

        try {
            $response = Http::baseUrl($this->baseUrl)
                ->timeout(10)
                ->get('api.php', [
                    'comm' => 'sendsms',
                    'user' => $username,
                    'pass' => $password,
                    'to' => $recipient,
                    'message' => $notification->toNepras($notifiable),
                    'sender' => $sender,
                ]);

            if (! $response->successful()) {
                Log::warning('Nepras notification request failed.', [
                    'recipient' => $recipient,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return;
            }

            $code = trim((string) $response->body());
            if ($code !== '1') {
                Log::warning('Nepras notification provider returned a failure code.', [
                    'recipient' => $recipient,
                    'code' => $code,
                ]);
            }
        } catch (Throwable $exception) {
            Log::warning('Nepras notification threw an exception.', [
                'recipient' => $recipient,
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
