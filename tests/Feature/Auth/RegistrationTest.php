<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        \Illuminate\Support\Facades\Mail::fake();
        \Illuminate\Support\Facades\Notification::fake();

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('onboarding.index', absolute: false));
        
        $user = \App\Models\User::where('email', 'test@example.com')->first();
        $this->assertNotNull($user);
        $this->assertNotNull($user->reference_token);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'role' => 'member',
            'status' => 'active',
        ]);
        $this->assertDatabaseHas('member_profiles', [
            'onboarding_completed' => false,
        ]);

        \Illuminate\Support\Facades\Notification::assertSentTo($user, \App\Notifications\CustomVerifyEmail::class);
        \Illuminate\Support\Facades\Mail::assertSent(\App\Mail\WelcomeOnboardMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email) && $mail->user->reference_token === $user->reference_token;
        });
    }
}
