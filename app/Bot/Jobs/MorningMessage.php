<?php
declare(strict_types=1);

namespace App\Bot\Jobs;

use App\Bot\ResponseMessages\CommandResponses\BaseCommand;
use App\Bot\ResponseMessages\CommandResponses\StatisticGatherer;
use App\Models\BroadcastMessage;
use App\Models\Chat;
use App\Models\MessageType;
use App\Models\OutboundMessage;
use App\Models\OutboundMessageText;
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
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Saver;

    /**
     * @var mixed
     */
    private $post;

    /**
     * @var Chat
     */
    private $chat;

    /**
     * @var mixed
     */
    private $user;


    /**
     * Create a new job instance.
     *
     * @param Chat $chat
     * @throws \InvalidArgumentException
     */
    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
        $this->user = $chat->users->first();

        $post = Post::query()->whereNotIn('status', ['draft', 'deleted'])->get()->random();
        $this->post = $post;
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

        $this->saveMessages();
    }
}
