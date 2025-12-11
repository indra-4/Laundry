<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class FixUserPasswords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:fix-passwords {--email= : Email of specific user to fix} {--password= : New password to set}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix incorrectly hashed user passwords';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->option('email');
        $newPassword = $this->option('password');

        if ($email) {
            // Fix specific user
            $user = User::where('email', $email)->first();
            
            if (!$user) {
                $this->error("User with email '{$email}' not found.");
                return 1;
            }

            if ($newPassword) {
                // Set new password (will be automatically hashed by model cast)
                $user->password = $newPassword;
                $user->save();
                $this->info("Password for '{$email}' has been reset successfully.");
                $this->info("You can now login with the new password.");
            } else {
                // Check if password is valid bcrypt
                $isValidBcrypt = $this->isValidBcryptHash($user->getAttributes()['password']);
                
                if (!$isValidBcrypt) {
                    $this->warn("User '{$email}' has an invalid password hash.");
                    $this->info("Run: php artisan user:fix-passwords --email={$email} --password=your_new_password");
                } else {
                    $this->info("User '{$email}' has a valid password hash.");
                }
            }
        } else {
            // Check all users
            $this->info("Checking all users for invalid password hashes...");
            
            $users = User::all();
            $invalidCount = 0;
            
            foreach ($users as $user) {
                $passwordHash = $user->getAttributes()['password'];
                $isValidBcrypt = $this->isValidBcryptHash($passwordHash);
                
                if (!$isValidBcrypt) {
                    $invalidCount++;
                    $this->warn("User '{$user->email}' has an invalid password hash.");
                }
            }
            
            if ($invalidCount === 0) {
                $this->info("All users have valid password hashes.");
            } else {
                $this->warn("Found {$invalidCount} user(s) with invalid password hashes.");
                $this->info("To fix a user, run: php artisan user:fix-passwords --email=user@example.com --password=new_password");
            }
        }

        return 0;
    }

    /**
     * Check if a hash is a valid bcrypt hash
     */
    private function isValidBcryptHash(string $hash): bool
    {
        // Bcrypt hashes start with $2y$ or $2a$ or $2b$ and are 60 characters long
        return preg_match('/^\$2[ayb]\$[0-9]{2}\$[A-Za-z0-9\.\/]{53}$/', $hash) === 1;
    }
}