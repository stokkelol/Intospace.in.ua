<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Bot\Broadcast\Morning;
use App\Models\Chat;
use Illuminate\Console\Command;

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
     * @return void
     */
    public function handle(): void
    {
        $chats = Chat::query()->with('users')->where('id', 73429990)->get();
        foreach ($chats as $chat) {
            \logger($chat->id);
        }
        (new Morning($chats))->handle();
    }
}
