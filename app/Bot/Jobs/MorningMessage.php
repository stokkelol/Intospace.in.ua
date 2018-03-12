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

    const LASTFM = 1;
    const POST = 2;

    /**
     * @var Post|null
     */
    private $post = null;

    /**
     * @var Chat
     */
    private $chat;

    /**
     * @var TelegramUser
     */
    private $user;

    /**
     * @var
     */
    private $type;

    /**
     * @var string|null
     */
    private $recommendation = null;


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

        $this->user->isLastfmExists() ? $this->type = static::LASTFM : $this->type = static::POST;

        $this->type === static::LASTFM
            ? $this->recommendation = $this->user->recommendations()->orderBy('id','desc')->first()
            : $this->post = Post::query()->whereNotIn('status', ['draft', 'deleted'])->get()->random();

        $this->post = Post::query()->whereNotIn('status', ['draft', 'deleted'])->get()->random();
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
            'text' => $this->recommendation ?? BaseCommand::POSTS_ENDPOINT . $this->post->slug
        ]);

        $this->saveMessages();
    }
}
