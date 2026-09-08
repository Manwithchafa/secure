<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;

class LoginNotification extends Notification
{
    use Queueable;

    public Carbon $loginTime;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public ?string $ipAddress = null,
        public ?string $userAgent = null,
        ?Carbon $loginTime = null
    ) {
        $this->loginTime = $loginTime ?? Carbon::now();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $formattedTime = $this->loginTime->format('F j, Y \a\t g:i A T');

        $message = (new MailMessage)
            ->subject('Security Alert: New Sign-in to Your Account')
            ->greeting("Hello {$notifiable->name},")
            ->line('We detected a new sign-in to your account.')
            ->line('**Sign-in Details:**')
            ->line("**Date & Time:** {$formattedTime}")
            ->line('**IP Address:** ' . ($this->ipAddress ?? 'Unknown'))
            ->line('**Device / Browser:** ' . ($this->userAgent ?? 'Unknown'));

        if (!empty($notifiable->reference_token)) {
            $message->line('**Reference Token:** `' . $notifiable->reference_token . '`');
        }

        return $message
            ->line('If this was you, no action is needed.')
            ->line('If you did NOT sign in, please reset your password immediately and contact support.')
            ->action('View Account', url('/'))
            ->salutation('Regards, ' . config('app.name'));
    }
}
