<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Console\Commands\testCommand;

class Kernel extends ConsoleKernel
{
    // added by guojf
    private $basePath = __DIR__ . '/../../storage/logs/schedule';

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        testCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command('testCommand:test_name')
            ->cron('* * * * *')
            ->sendOutputTo($this->createLogFile('testCommand'));
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

    // added by guojf
    protected function createLogFile(string $taskName)
    {
        $logPath = $this->basePath .'/'. $taskName;
        is_dir($logPath) OR mkdir($logPath, 0777, true);
        return $logPath . '/' . date('Y-m-d') . '.log';
    }
}
