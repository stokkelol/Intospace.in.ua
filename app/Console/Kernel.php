<?php
declare(strict_types=1);

namespace App\Console;

use App\Console\Commands\Recommendations;
use App\Console\Commands\SendAfternoonMessage;
use App\Console\Commands\SendEveningMessage;
use App\Console\Commands\SendMorningMessage;
use App\Console\Commands\SocialReminder;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * Class Kernel
 *
 * @package App\Console
 */
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(SendMorningMessage::class)->dailyAt('11:00');
        $schedule->command(SendAfternoonMessage::class)->dailyAt('16:00');
        $schedule->command(SendEveningMessage::class)->dailyAt('20:00');
        $schedule->command(SocialReminder::class)->mondays()->at('13:00');
        $schedule->command(Recommendations::class)->dailyAt('00:00');
    }
}
