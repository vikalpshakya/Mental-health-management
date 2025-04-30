<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UpdateUserRole extends Command
{
    protected $signature = 'user:role {email} {role}';
    protected $description = 'Update the role of a user by email';

    public function handle()
    {
        $email = $this->argument('email');
        $role = $this->argument('role');

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email {$email} not found.");
            return 1;
        }

        $user->role = $role;
        $user->save();

        $this->info("Successfully updated role for user {$email} to {$role}");
        return 0;
    }
} 