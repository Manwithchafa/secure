<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    /**
     * Mark the email address from a valid signed verification link as verified.
     */
    public function __invoke(Request $request, string $id, string $hash): RedirectResponse
    {
        $user = User::query()->findOrFail($id);

        abort_unless(hash_equals(sha1($user->getEmailForVerification()), $hash), 403);

        $authenticatedUser = $request->user();
        abort_if($authenticatedUser && ! $authenticatedUser->is($user), 403);

        if ($user->hasVerifiedEmail()) {
            return $this->redirectAfterVerification($request);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return $this->redirectAfterVerification($request);
    }

    private function redirectAfterVerification(Request $request): RedirectResponse
    {
        return $request->user()
            ? redirect()->intended(route('dashboard', absolute: false).'?verified=1')
            : redirect()->route('login')->with('status', 'email-verified');
    }
}
