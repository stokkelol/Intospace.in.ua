<?php
declare(strict_types=1);

namespace App\Bot\Jobs;

use App\Bot\ResponseMessages\CommandResponses\BaseCommand;
use App\Models\Chat;
use App\Models\Post;
use App\Models\TelegramUser;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Telegram\Bot\Api;

/**
 * Class MorningMessage
 *
 * @package App\Bot\Jobs
 */
class MorningMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var TelegramUser
     */
    private $chat;

    /**
     * @var Api
     */
    private $telegram;

    /**
     * Create a new job instance.
     *
     * @param Chat $chat
     * @param Api $telegram
     */
    public function __construct(Chat $chat, Api $telegram)
    {
        $this->chat = $chat;
        $this->telegram = $telegram;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $user = $this->chat->users;

//        $post = Post::query()->get()->random();

        $this->telegram->sendMessage([
            'chat_id' => $this->chat->id,
            'text' => 'HI!'
        ]);
    }
}
