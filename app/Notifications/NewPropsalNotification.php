<?php

namespace App\Notifications;

use App\Channels\Log;
use App\Channels\Nepras;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;

class NewPropsalNotification extends Notification
{
    use Queueable;

    protected $proposal;

    protected $freelancer;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Proposal $proposal, User $freelancer)
    {
        $this->proposal = $proposal;
        $this->freelancer = $freelancer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $via = [Log::class];

        if (!$notifiable instanceof AnonymousNotifiable) {
            if ($this->canSendViaNepras($notifiable)) {
                $via[] = Nepras::class;
            }

            if ($notifiable->notify_mail && filled($notifiable->routeNotificationForMail($this))) {
                $via[] = 'mail';
            }

            if ($notifiable->notify_sms && $this->canSendViaNexmo($notifiable)) {
                $via[] = 'nexmo';
            }
        }

        return $via;
    }

    protected function canSendViaNepras($notifiable): bool
    {
        return filled(config('services.nepras.user'))
            && filled(config('services.nepras.pass'))
            && filled(config('services.nepras.sender'))
            && filled($notifiable->routeNotificationForNepras($this));
    }

    protected function canSendViaNexmo($notifiable): bool
    {
        return filled(config('services.nexmo.key'))
            && filled(config('services.nexmo.secret'))
            && filled($notifiable->routeNotificationForNexmo($this));
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $body = sprintf(
            '%s applied for a job %s',
            $this->freelancer->name,
            $this->proposal->project->title,
        );

        $message = new MailMessage;
        $message->subject('New Proposal')
            ->from('notifications@localhost', 'E-Lancer Notifications')
            ->greeting('Hello ' . ($notifiable->name ?? ''))
            ->line($body)
            ->action('View to Proposal', route('projects.show', $this->proposal->project_id))
            ->line('Thank you for using our application!');
        // ->view('mails.proposal', [
        //     'proposal' => $this->proposal,
        //     'notifiable' => $notifiable,
        //     'freelancer' => $this->freelancer
        // ]);

        return $message;
    }

    public function toDatabase($notifiable)
    {
        $body = sprintf(
            '%s applied for a job %s',
            $this->freelancer->name,
            $this->proposal->project->title,
        );

        return [
            'title' => 'New Proposal',
            'body' => $body,
            'icon' => 'icon-material-outline-group',
            'url' => route('projects.show', $this->proposal->project_id),
        ];
    }

    public function toBroadcast($notifiable)
    {
        $body = sprintf(
            '%s applied for a job %s',
            $this->freelancer->name,
            $this->proposal->project->title,
        );

        return new BroadcastMessage([
            'title' => 'New Proposal',
            'body' => $body,
            'icon' => 'icon-material-outline-group',
            'url' => route('projects.show', $this->proposal->project_id),
        ]);
    }

    public function toNexmo($notifiable)
    {
        $body = sprintf(
            '%s applied for a job %s',
            $this->freelancer->name,
            $this->proposal->project->title,
        );

        $message = new NexmoMessage();
        $message->content($body);

        return $message;
    }

    public function toLog($notifiable)
    {
        $body = sprintf(
            '%s applied for a job %s',
            $this->freelancer->name,
            $this->proposal->project->title,
        );

        return $body;
    }

    public function toNepras($notifiable)
    {
        $body = sprintf(
            '%s applied for a job %s',
            $this->freelancer->name,
            $this->proposal->project->title,
        );

        return $body;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
    }
}
