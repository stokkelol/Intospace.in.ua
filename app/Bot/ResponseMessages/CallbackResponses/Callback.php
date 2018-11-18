<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CallbackResponses;

use App\Bot\ResponseMessages\Interfaces\CallbackResponse;
use App\Bot\ResponseMessages\Response;
use App\Models\BandTelegramUser;
use App\Models\OutboundMessage;
use App\Models\OutboundMessageContext;
use App\Models\OutboundMessageText;
use Telegram\Bot\Objects\Message;

/**
 * Class Callback
 *
 * @package App\Bot\ResponseMessages\CallbackResponses
 */
abstract class Callback implements CallbackResponse
{
    /**
     * @var
     */
    protected $data;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var OutboundMessageText|null
     */
    protected $message = null;

    /**
     * @var BandTelegramUser|null
     */
    protected $pivot = null;

    /**
     * Callback constructor.
     *
     * @param array $data
     * @param Response $response
     */
    public function __construct(array $data, Response $response)
    {
        $this->data = $data;
        $this->response = $response;

        $this->parse();
    }

    /**
     * @return string
     */
    abstract protected function getText(): string;

    /**
     * @return Message
     */
    protected function sendTextResponse(): Message
    {
        return $this->response->getApi()->sendMessage([
            'chat_id' => $this->response->getChat()->id,
            'text' => $this->getText(),
            'parse_mode' => $this->response->getParseMode(),
        ]);
    }

    /**
     * @return void
     */
    protected function parse(): void
    {
        $this->message = OutboundMessageText::query()->with("outboundMessage.context")->find($this->data['id']);
        $this->pivot = BandTelegramUser::query()->where("user_id", '=', $this->response->getUser()->id)
            ->where('band_id', '=', $this->message->outboundMessage->context->band_id)->first();

        if ($this->pivot === null) {
            $this->pivot = new BandTelegramUser();
            $this->pivot->user()->associate($this->response->getUser());
            $this->pivot->band()->associate($this->message->outboundMessage->context->band);
            $this->pivot->lastfm_count = null;
        }
    }
}