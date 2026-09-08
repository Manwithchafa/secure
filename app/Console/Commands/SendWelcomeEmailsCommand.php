<?php

namespace App\Console\Commands;

use App\Mail\WelcomeOnboardMail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendWelcomeEmailsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send-welcome
                            {--email= : Target a single email address for testing}
                            {--user= : Target a single user ID for testing}
                            {--dry-run : List recipient users without sending emails}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send professional welcome onboard email with company logo to users';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $emailFilter = $this->option('email');
        $userIdFilter = $this->option('user');
        $isDryRun = (bool) $this->option('dry-run');

        $query = User::query();

        if ($emailFilter) {
            $query->where('email', $emailFilter);
        } elseif ($userIdFilter) {
            $query->where('id', $userIdFilter);
        } else {
            $query->where('status', 'active');
        }

        $users = $query->get();

        if ($users->isEmpty() && $emailFilter) {
            $user = new User();
            $user->name = explode('@', $emailFilter)[0];
            $user->email = $emailFilter;
            $user->role = 'member';
            $user->status = 'active';
            $users = collect([$user]);
        }

        if ($users->isEmpty()) {
            $this->warn('No matching users found.');
            return Command::SUCCESS;
        }

        $this->info("Found {$users->count()} recipient(s).");

        if ($isDryRun) {
            $this->table(['ID', 'Name', 'Email', 'Role', 'Status'], $users->map(fn ($u) => [
                $u->id,
                $u->name,
                $u->email,
                $u->role,
                $u->status,
            ]));
            $this->info('Dry-run completed. No emails were sent.');
            return Command::SUCCESS;
        }

        $sentCount = 0;
        $failedCount = 0;

        $progressBar = $this->output->createProgressBar($users->count());
        $progressBar->start();

        foreach ($users as $user) {
            try {
                Mail::to($user->email)->send(new WelcomeOnboardMail($user));
                $sentCount++;
            } catch (Throwable $e) {
                $failedCount++;
                $this->error("\nFailed to send to {$user->email}: " . $e->getMessage());
            }
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        $this->info("Successfully sent {$sentCount} welcome onboard email(s).");

        if ($failedCount > 0) {
            $this->warn("Failed to send {$failedCount} email(s). Check logs for details.");
        }

        return Command::SUCCESS;
    }
}
