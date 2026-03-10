<?php

namespace App\Notifications;

use App\Models\TheCase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCaseNotification extends Notification
{
    use Queueable;

    protected $message;
    protected $user;
    protected $case;

    /**
     * Create a new notification instance.
     */
    public function __construct($message, $user, TheCase $case)
    {
        $this->message = $message;
        $this->user = $user;
        $this->case = $case;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line($this->message)
            ->line('User: ' . $this->user->name)
            ->line('Case ID: ' . $this->case->id)
            ->action('View Case', url('/cases/' . $this->case->id));
    }

    // data stored in database
    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Case Alert',
            'user_name' => $this->user->name,
            'message' => $this->message,
            'type' => 'info',
            'case_id' => $this->case->id,
            'url' => '/cases/' . $this->case->id
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
