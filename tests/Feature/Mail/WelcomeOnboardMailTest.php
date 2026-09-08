<?php

namespace Tests\Feature\Mail;

use App\Mail\WelcomeOnboardMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class WelcomeOnboardMailTest extends TestCase
{
    use RefreshDatabase;

    public function test_welcome_onboard_mail_content_is_rendered(): void
    {
        $user = User::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ]);

        $mailable = new WelcomeOnboardMail($user);

        $mailable->assertSeeInHtml('Jane Doe');
        $mailable->assertSeeInHtml('Welcome Onboard');
        $mailable->assertSeeInHtml('Country Culture Acres');
        $mailable->assertHasSubject('Welcome to Country Culture Acres – Your Portal Access is Ready');
    }

    public function test_artisan_send_welcome_command_dispatches_mail(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'status' => 'active',
        ]);

        $this->artisan('email:send-welcome', ['--user' => $user->id])
            ->assertExitCode(0);

        Mail::assertSent(WelcomeOnboardMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    public function test_artisan_send_welcome_dry_run_does_not_send_mail(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'status' => 'active',
        ]);

        $this->artisan('email:send-welcome', ['--dry-run' => true])
            ->assertExitCode(0);

        Mail::assertNothingSent();
    }
}
