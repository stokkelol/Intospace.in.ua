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
     * @var OutboundMessage
     */
    private $outboundMessage;

    /**
     * @var BroadcastMessage
     */
    private $broadcastMessage;


    /**
     * Create a new job instance.
     *
     * @param Chat $chat
     * @param OutboundMessage $outboundMessage
     * @param BroadcastMessage $broadcastMessage
     */
    public function __construct(Chat $chat, OutboundMessage $outboundMessage, BroadcastMessage $broadcastMessage)
    {
        $this->chat = $chat;
        \logger($outboundMessage);
        \logger($broadcastMessage);
        $this->outboundMessage = $outboundMessage;
        $this->broadcastMessage = $broadcastMessage;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $user = $this->chat->users;
        \logger($user->id);
        $post = Post::query()->get()->random();

        $telegram = Container::getInstance()->make(Api::class);

        $this->outboundMessage->chat()->associate($this->chat);
        $this->outboundMessage->user()->associate($user);
        $this->outboundMessage->message_type_id = MessageType::ENTITIES;
        $this->outboundMessage->save();
        \logger($this->outboundMessage);

        $this->broadcastMessage->user()->associate($user);
        $this->broadcastMessage->chat()->associate($this->chat);
        $this->broadcastMessage->outboundMessage()->associate($this->outboundMessage);
        $this->broadcastMessage->save();
        \logger($this->broadcastMessage);

        $telegram->sendMessage([
            'chat_id' => $this->chat->id,
            'text' => BaseCommand::POSTS_ENDPOINT . $post->slug
        ]);
    }
}
