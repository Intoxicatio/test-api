<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('fetch orders')
            ->twiceDaily(14, 2)
            ->timezone('Europe/moscow')
            ->withoutOverlapping(480)
            ->onOneServer();
        $schedule->command('fetch incomes')
            ->twiceDaily(14,2)
            ->timezone('Europe/moscow')
            ->withoutOverlapping(480)
            ->onOneServer();
        $schedule->command('fetch sales')
            ->twiceDaily(14, 2)
            ->timezone('Europe/moscow')
            ->withoutOverlapping(480)
            ->onOneServer();
        $schedule->command('fetch stocks')
            ->twiceDaily(14, 2)
            ->timezone('Europe/moscow')
            ->withoutOverlapping(480)
            ->onOneServer();
        // $schedule->command('crond:log')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
