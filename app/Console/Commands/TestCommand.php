<?php

namespace App\Console\Commands;

use App\Models\CompanySubunit;
use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TestCommand extends Command
{
    protected $signature = 'test';

    protected $description = 'Test command';

    public function handle(): int
    {
        dd(Carbon::now()->format('F'));

        return Command::SUCCESS;
    }
}
