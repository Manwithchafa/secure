<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class CustomVerifyEmail extends VerifyEmail
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Verify Your Email Address – Country Culture Acres')
            ->view('emails.verify-email', [
                'name' => $notifiable->name,
                'email' => $notifiable->email,
                'referenceToken' => $notifiable->reference_token ?? null,
                'verificationUrl' => $verificationUrl,
            ]);
    }
}
