<?php

namespace App\Console\Commands\Generations;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class GenerateUsersPasswordsCommand extends Command
{
    protected $signature = 'generate:users_passwords';

    protected $description = 'Command description';

    public function handle(): int
    {
        $users = User::all();

        /** @var User $user */
        foreach ($users as $user) {
            $user->password = Hash::make('123456789' . $user->id);
            $user->save();
        }

        return Command::SUCCESS;
    }
}
