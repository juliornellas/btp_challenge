<?php

namespace App\Console\Commands;

use App\Jobs\GetUsersWeatherJob;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;

class CheckWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:weather';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check users weather';

    /**
     * Execute the console command.
     */
    public function handle(Schedule $schedule): void
    {
        $schedule->job(new GetUsersWeatherJob);
    }
}
