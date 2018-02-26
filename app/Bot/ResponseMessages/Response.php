<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages;

use App\Bot\Interfaces\ResponseMessage;
use App\Models\Chat;
use App\Models\MessageType;
use App\Models\OutboundMessage;
use App\Models\OutboundMessageText;
use App\Models\TelegramUser;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Message;

/**
 * Class Factory
 *
 * @package App\Bot\ResponseMessages
 */
abstract class Response implements ResponseMessage
{
    /**
     * @var Api
     */
    protected $telegram;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var array
     */
    protected $request;

    /**
     * @var
     */
    protected $chat;

    /**
     * @var array
     */
    protected $responseMessage = [];

    /**
     * @var TelegramUser
     */
    protected $user;

    /**
     * @var bool
     */
    protected $responseIsArray = false;

    /**
     * @var int
     */
    protected $type;

    /**
     * @var
     */
    protected $parseMode = 'Markdown';

    /**
     * @param int $type
     * @param Api $telegram
     * @return ResponseMessage
     */
    public static function factory(int $type, Api $telegram)
    {
        switch ($type) {
            case MessageType::TEXT:
                return new TextResponse($telegram, $type);
                break;
            case MessageType::ENTITIES:
                return new CommandResponse($telegram, $type);
                break;
        }
    }

    /**
     * @return void
     */
    abstract protected function createResponse(): void;

    /**
     * Factory constructor.
     *
     * @param Api $telegram
     * @param int $type
     */
    public function __construct(Api $telegram, int $type)
    {
        $this->telegram = $telegram;
        $this->type = $type;
    }

    /**
     * @return TelegramUser
     */
    public function getUser(): TelegramUser
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return Chat
     */
    public function getChat(): Chat
    {
        return $this->chat;
    }

    /**
     * @param array $request
     * @param Chat $chat
     * @param TelegramUser $user
     */
    public function setParameters(array $request, Chat $chat, TelegramUser $user): void
    {
        $this->request = $request;
        $this->chat = $chat;
        $this->user = $user;
        $this->text = $request['message']['text'];
    }

    /**
     * @return Message
     */
    public function sendResponse()
    {
        $this->createResponse();
        $this->beforeResponse();

        $this->send();
    }

    /**
     * @return void
     */
    protected function beforeResponse(): void
    {
        $outboundMessage = new OutboundMessage();
        $outboundMessage->message_type_id = $this->type;
        $outboundMessage->user_id = $this->user->id;
        $outboundMessage->chat_id = $this->chat->id;
        $outboundMessage->save();

        foreach ($this->responseMessage as $message) {
            $text = new OutboundMessageText();
            $text->message = $message;
            $text->outboundMessage()->associate($outboundMessage);
            $text->save();
        }
    }

    /**
     * @return void
     */
    protected function send(): void
    {
        foreach ($this->responseMessage as $message) {
            $this->telegram->sendMessage([
                'chat_id' => $this->chat->id,
                'text' => $message,
                'parse_mode' => $this->parseMode
            ]);
        }
    }
}