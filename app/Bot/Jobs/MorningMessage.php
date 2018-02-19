<?php
declare(strict_types=1);

namespace App\Bot\Jobs;

use App\Bot\ResponseMessages\CommandResponses\BaseCommand;
use App\Bot\ResponseMessages\CommandResponses\StatisticGatherer;
use App\Models\BroadcastMessage;
use App\Models\Chat;
use App\Models\MessageType;
use App\Models\OutboundMessage;
use App\Models\Post;
use App\Models\TelegramUser;
use Illuminate\Bus\Queueable;
use Illuminate\Container\Container;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
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
     * @var mixed
     */
    private $post;

    /**
     * @var OutboundMessage
     */
    protected $outboundMessage;

    /**
     * @var BroadcastMessage
     */
    protected $broadcastMessage;

    /**
     * @var Chat
     */
    protected $chat;


    /**
     * Create a new job instance.
     *
     * @param Chat $chat
     * @param OutboundMessage $outboundMessage
     * @param BroadcastMessage $broadcastMessage
     * @throws \InvalidArgumentException
     */
    public function __construct(Chat $chat, OutboundMessage $outboundMessage, BroadcastMessage $broadcastMessage)
    {
        \logger($chat->id);
        $this->chat = $chat;
        $user = $chat->users->first();

        $this->post = Post::query()->get()->random();

        $this->saveMessages($outboundMessage, $broadcastMessage, $user);

        $gatherer = new StatisticGatherer();
        $gatherer->associatePostAndUser($this->post, $user);
        $gatherer->associateTagAndUser($this->post, $user);

    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \InvalidArgumentException
     */
    public function handle(): void
    {
        $telegram = Container::getInstance()->make(Api::class);

        $telegram->sendMessage([
            'chat_id' => $this->chat->id,
            'text' => BaseCommand::POSTS_ENDPOINT . $this->post->slug
        ]);
    }


    /**
     * @param OutboundMessage $outboundMessage
     * @param BroadcastMessage $broadcastMessage
     * @param TelegramUser $user
     */
    protected function saveMessages(OutboundMessage $outboundMessage, BroadcastMessage $broadcastMessage, TelegramUser $user): void
    {
        $this->outboundMessage = $outboundMessage;
        $this->outboundMessage->chat()->associate($this->chat);
        $this->outboundMessage->user()->associate($user);
        $this->outboundMessage->message_type_id = MessageType::ENTITIES;
        $this->outboundMessage->save();

        $this->broadcastMessage = $broadcastMessage;
        $this->broadcastMessage->user()->associate($user);
        $this->broadcastMessage->chat()->associate($this->chat);
        $this->broadcastMessage->outboundMessage()->associate($this->outboundMessage);
        $this->broadcastMessage->save();
    }
}
