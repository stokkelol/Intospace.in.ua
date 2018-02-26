<?php
declare(strict_types=1);

namespace App\Bot\Jobs;

use App\Models\TelegramUser;
use Illuminate\Bus\Queueable;
use Illuminate\Container\Container;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Telegram\Bot\Api;

/**
 * Class SocialReminder
 *
 * @package App\Bot\Jobs
 */
class SocialReminder implements ShouldQueue
{
    const MESSAGE = 'Hi! In case you forget - you can hit me with {social_network}#{nickname} message,
        so i can serve you better! For example: lastfm#nickname, facebook#nickname';

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var TelegramUser
     */
    private $user;

    /**
     * @var Api
     */
    private $telegram;

    /**
     * Create a new job instance.
     *
     * @param TelegramUser $user
     */
    public function __construct(TelegramUser $user)
    {
        $this->user = $user;
        $this->telegram = Container::getInstance()->make(Api::class);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->telegram->sendMessage([
            'chat_id' => $this->user->chats->first()->id,
            'text' => static::MESSAGE
        ]);
    }
}
