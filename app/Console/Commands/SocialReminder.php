<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\TelegramUser;
use Illuminate\Console\Command;

/**
 * Class SocialReminder
 *
 * @package App\Console\Commands
 */
class SocialReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = TelegramUser::query()->whereDoesntHave('socials')->get();

        foreach ($users as $user) {
            \dispatch(new \App\Bot\Jobs\SocialReminder($user));
        }
    }
}
