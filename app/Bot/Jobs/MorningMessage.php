<?php
declare(strict_types=1);

namespace App\Bot\Jobs;

use App\Bot\ResponseMessages\CommandResponses\BaseCommand;
use App\Models\BroadcastMessage;
use App\Models\Chat;
use App\Models\MessageType;
use App\Models\OutboundMessage;
use App\Models\Post;
use App\Models\TelegramUser;
use Illuminate\Bus\Queueable;
use Illuminate\Container\Container;
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
     * Create a new job instance.
     *
     * @param Chat $chat
     */
    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $user = $this->chat->users;
        \logger($user);
        $post = Post::query()->get()->random();

        $telegram = Container::getInstance()->make(Api::class);

        $outboundMessage = new OutboundMessage();
        $outboundMessage->chat()->associate($this->chat);
        $outboundMessage->user()->associate($user);
        $outboundMessage->message_type_id = MessageType::ENTITIES;
        $outboundMessage->save();
        \logger($outboundMessage);

        $broadcastMessage = new BroadcastMessage();
        $broadcastMessage->user()->associate($user);
        $broadcastMessage->chat()->associate($this->chat);
        $broadcastMessage->outboundMessage()->associate($outboundMessage);
        $broadcastMessage->save();
        \logger($broadcastMessage);

        $telegram->sendMessage([
            'chat_id' => $this->chat->id,
            'text' => BaseCommand::POSTS_ENDPOINT . $post->slug
        ]);
    }
}
