<?php
declare(strict_types=1);

namespace App\Bot\Jobs;

use App\Bot\Keyboard\Base;
use App\Bot\Message\Assembler;
use App\Bot\Youtube\Youtube;
use App\Models\Band;
use App\Models\Chat;
use App\Models\TelegramUser;
use App\Models\TelegramUserRecommendation;
use App\Support\Logger\Logger;
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

    const YOUTUBE_ENDPOINT  = 'https://www.youtube.com/watch?v=';

    /**
     * @var Chat
     */
    private $chat;

    /**
     * @var TelegramUser
     */
    private $user;

    /**
     * @var int
     */
    private $type;

    /**
     * @var TelegramUserRecommendation|null
     */
    private $recommendation;

    /**
     * @var string|null
     */
    private $message;

    /**
     * @var Band|null
     */
    private $band;

    /**
     * @var Youtube
     */
    private $youtubeHandler;

    /**
     * @var string
     */
    protected $parseMode = 'Markdown';

    /**
     * Create a new job instance.
     *
     * @param Chat $chat
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
        $this->user = $chat->users->first();
        $this->youtubeHandler = new Youtube();
        $this->user->isLastfmExists() ? $this->type = static::LASTFM : $this->type = static::POST;
        $this->recommendation = $this->user->recommendations()->where('is_dispatched', '=', false)
            ->orderBy('id','desc')->first();

        $this->prepareMessage();
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \InvalidArgumentException
     */
    public function handle(): void
    {
        /** @var Api $telegram */
        $telegram = Container::getInstance()->make(Api::class);
        $outboundMessage = $this->saveMessages();
        $keyboard = (new Base())->prepare($outboundMessage->texts->first());
        $payload = new Assembler($this->chat, $this->message, $keyboard);

        $response = $telegram->sendMessage($payload->assemble());
        $isDispatched = $response->getStatus() === true;

        if ($this->recommendation !== null) {
            $this->recommendation->is_dispatched = $isDispatched;
            $this->recommendation->outboundMessage()->associate($outboundMessage);
            $this->recommendation->save();
        }
    }

    /**
     * @param \Throwable $e
     */
    public function failed(\Throwable $e): void
    {
        Logger::exception($e);
    }

    /**
     * @return void
     * @throws \InvalidArgumentException
     */
    private function prepareMessage(): void
    {
        $this->prepareFromPayload();
    }

    /**
     * @return void
     */
    private function prepareFromPayload(): void
    {
        $this->recommendation !== null ? $this->prepareFromRecommendation() : $this->prepareFromBand();
    }

    private function prepareFromRecommendation(): void
    {
        $this->message = $this->recommendation->getPayload();
        $this->band = $this->recommendation->band;
    }

    /**
     * @return void
     * @throws \InvalidArgumentException
     */
    private function prepareFromBand(): void
    {
        do {
            $this->band = Band::query()->inRandomOrder()->first();
            $response = $this->youtubeHandler->searchBand($this->band);
        } while (!\is_array($response));
        $this->message = static::YOUTUBE_ENDPOINT . $response[0]->id->videoId;
    }
}
