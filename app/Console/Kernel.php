<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\UpdateDomains::class,
        Commands\ImportTickets::class,
        Commands\UpdateTickets::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('update:domains')->withoutOverlapping();

        $schedule->command('import:tickets')->dailyAt('21:00');
        $schedule->command('update:tickets')->dailyAt('21:00');
        
        
        /* $schedule->command('queue:restart')
            ->everyFiveMinutes(); */

        /* if (stripos((string) shell_exec('ps xf | grep \'[q]ueue:work\''), 'artisan queue:work') === false) {
            $schedule->command('queue:work --queue=default --sleep=3')->everyMinute()->appendOutputTo(storage_path() . '/logs/scheduler.log');
        } */
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
