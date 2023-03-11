<?php

namespace App\Console\Commands\Generations;

use App\Models\Resource;
use App\Models\User;
use Illuminate\Console\Command;

class GenerateResourcesCommand extends Command
{
    protected $signature = 'generate:resources';

    public function handle(): int
    {
        $names = [
            'Electricity',
            'Water',
            'Gas',
            'Diesel',
        ];

        $users = User::all();

        /** @var User $user */
        foreach ($users as $user) {
            foreach ($names as $name) {
                Resource::updateOrCreate(
                    ['user_id' => $user->getKey(), 'name' => $name],
                    ['user_id' => $user->getKey(), 'name' => $name],
                );
            }
        }

        return Command::SUCCESS;
    }
}
