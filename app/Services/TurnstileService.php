<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TurnstileService
{
    public function isConfigured(): bool
    {
        $missing = [];

        if (! filled(config('services.turnstile.site_key'))) {
            $missing[] = 'TURNSTILE_SITE_KEY';
        }

        if (! filled(config('services.turnstile.secret_key'))) {
            $missing[] = 'TURNSTILE_SECRET_KEY';
        }

        if ($missing === []) {
            return true;
        }

        Log::error('Cloudflare Turnstile is not configured; registration is unavailable.', [
            'missing' => $missing,
        ]);

        return false;
    }

    public function verify(mixed $token): bool
    {
        if (! $this->isConfigured() || ! is_string($token) || $token === '' || strlen($token) > 2048) {
            return false;
        }

        try {
            $response = Http::asForm()
                ->connectTimeout(2)
                ->timeout(5)
                ->post(config('services.turnstile.verify_url'), [
                    'secret' => config('services.turnstile.secret_key'),
                    'response' => $token,
                ]);
        } catch (ConnectionException) {
            Log::warning('Cloudflare Turnstile verification could not be reached.');

            return false;
        }

        if (! $response->successful()) {
            Log::warning('Cloudflare Turnstile verification returned an unsuccessful HTTP status.', [
                'status' => $response->status(),
            ]);

            return false;
        }

        $result = $response->json();

        if (! is_array($result) || ($result['success'] ?? null) !== true) {
            Log::notice('Cloudflare Turnstile rejected a registration challenge.');

            return false;
        }

        return true;
    }
}
