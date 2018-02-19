<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Bot\Jobs\MorningMessage;
use App\Models\Chat;
use App\Models\ChatUser;
use App\Models\TelegramUser;
use Illuminate\Console\Command;
use Telegram\Bot\Api;

/**
 * Class SendMorningMessage
 *
 * @package App\Console\Commands
 */
class SendMorningMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:morning';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send morning message';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $chats = Chat::query()->with('users')->get();

        foreach ($chats as $chat) {
            \dispatch(new MorningMessage($chat));
        }
    }
}
