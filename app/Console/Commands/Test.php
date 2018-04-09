<?php
declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Telegram\Bot\Api;

/**
 * Class Test
 *
 * @package App\Console\Commands
 */
class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'For telegram testing purposes';

    /**
     * Execute the console command.
     *
     * @param Api $api
     * @return mixed
     */
    public function handle(Api $api)
    {
        $api->sendMessage([
            'chat_id' => 73429990,
            'text' => 'Hello!',
            'reply_markup' => [
                'keyboard' => [
                    [
                        ['1', '2']
                    ]
                ]
            ]
        ]);
    }
}
