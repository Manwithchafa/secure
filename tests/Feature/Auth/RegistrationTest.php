<?php

namespace Tests\Feature\Auth;

use App\Mail\WelcomeOnboardMail;
use App\Models\User;
use App\Notifications\CustomVerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'services.turnstile.site_key' => 'test-site-key',
            'services.turnstile.secret_key' => bin2hex(random_bytes(16)),
        ]);
    }

    public function test_registration_screen_renders_the_turnstile_widget(): void
    {
        $response = $this->get('/register');

        $response->assertOk()
            ->assertSee('https://challenges.cloudflare.com/turnstile/v0/api.js')
            ->assertSee('class="cf-turnstile" data-sitekey="test-site-key"', false)
            ->assertDontSee(config('services.turnstile.secret_key'));
    }

    public function test_registration_page_fails_closed_when_turnstile_is_not_configured(): void
    {
        config(['services.turnstile.site_key' => null]);
        Log::spy();

        $this->get('/register')
            ->assertOk()
            ->assertSee('Registration is temporarily unavailable')
            ->assertDontSee('cf-turnstile');

        Log::shouldHaveReceived('error')->once();
    }

    public function test_registration_is_rejected_when_the_challenge_is_missing(): void
    {
        Mail::fake();
        Notification::fake();
        $registrationData = $this->registrationData();
        unset($registrationData['cf-turnstile-response']);

        $this->from('/register')
            ->post('/register', $registrationData)
            ->assertRedirect('/register')
            ->assertSessionHasErrors('cf-turnstile-response');

        $this->assertDatabaseCount('users', 0);
        $this->assertDatabaseCount('member_profiles', 0);
        Http::assertNothingSent();
        Notification::assertNothingSent();
        Mail::assertNothingSent();
    }

    public function test_registration_is_rejected_when_cloudflare_rejects_the_challenge(): void
    {
        Http::fake([
            '*' => Http::response(['success' => false], 200),
        ]);
        Mail::fake();
        Notification::fake();

        $this->from('/register')
            ->post('/register', $this->registrationData())
            ->assertRedirect('/register')
            ->assertSessionHasErrors('cf-turnstile-response');

        $this->assertDatabaseCount('users', 0);
        $this->assertDatabaseCount('member_profiles', 0);
        Notification::assertNothingSent();
        Mail::assertNothingSent();
    }

    public function test_registration_is_rejected_safely_when_cloudflare_is_unavailable(): void
    {
        Http::fake([
            '*' => function () {
                throw new ConnectionException('Cloudflare unavailable');
            },
        ]);
        Mail::fake();
        Notification::fake();

        $this->from('/register')
            ->post('/register', $this->registrationData())
            ->assertRedirect('/register')
            ->assertSessionHasErrors('cf-turnstile-response');

        $this->assertDatabaseCount('users', 0);
        $this->assertDatabaseCount('member_profiles', 0);
        Notification::assertNothingSent();
        Mail::assertNothingSent();
    }

    public function test_registration_is_rejected_when_cloudflare_request_times_out(): void
    {
        Http::fake([
            '*' => function () {
                throw new ConnectionException('Cloudflare request timed out');
            },
        ]);
        Mail::fake();
        Notification::fake();

        $this->from('/register')
            ->post('/register', $this->registrationData())
            ->assertRedirect('/register')
            ->assertSessionHasErrors('cf-turnstile-response');

        $this->assertDatabaseCount('users', 0);
        $this->assertDatabaseCount('member_profiles', 0);
        Notification::assertNothingSent();
        Mail::assertNothingSent();
    }

    public function test_new_users_can_register_after_successful_turnstile_verification(): void
    {
        Http::fake([
            '*' => Http::response(['success' => true]),
        ]);
        Mail::fake();
        Notification::fake();

        $response = $this->post('/register', $this->registrationData());

        $this->assertAuthenticated();
        $response->assertRedirect(route('onboarding.index', absolute: false));

        $user = User::where('email', 'test@example.com')->first();
        $this->assertNotNull($user);
        $this->assertNotNull($user->reference_token);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'role' => 'member',
            'status' => 'active',
        ]);
        $this->assertDatabaseHas('member_profiles', [
            'user_id' => $user->id,
            'onboarding_completed' => false,
        ]);

        Notification::assertSentTo($user, CustomVerifyEmail::class);
        Mail::assertSent(WelcomeOnboardMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email) && $mail->user->reference_token === $user->reference_token;
        });

        Http::assertSent(function (ClientRequest $request) {
            return $request->url() === config('services.turnstile.verify_url')
                && $request['response'] === 'test-turnstile-token'
                && $request['secret'] === config('services.turnstile.secret_key')
                && ! array_key_exists('remoteip', $request->data());
        });
    }

    /**
     * @return array<string, string>
     */
    private function registrationData(): array
    {
        return [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'cf-turnstile-response' => 'test-turnstile-token',
        ];
    }
}
