<?php

namespace App\Listeners;

use App\Notifications\LoginNotification;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Log;
use Throwable;

class SendLoginNotificationListener
{
    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        try {
            $user = $event->user;

            if (! $user) {
                return;
            }

            $ip = request()->ip();
            $userAgent = request()->userAgent();

            $user->notify(new LoginNotification($ip, $userAgent));

            Log::info('Login notification email dispatched.', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $ip,
            ]);
        } catch (Throwable $e) {
            Log::error('Failed to send login notification email.', [
                'user_id' => $event->user->id ?? null,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
