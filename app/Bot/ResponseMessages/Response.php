<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages;

use App\Bot\Interfaces\ResponseMessage;
use App\Bot\Keyboard\Base;
use App\Bot\ResponseMessages\Interfaces\Command;
use App\Models\Chat;
use App\Models\MessageType;
use App\Models\OutboundMessage;
use App\Models\OutboundMessageContext;
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
     * @var Command
     */
    protected $command;

    /**
     * @var array
     */
    protected $keyboard = [];

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
     * @return void
     */
    public function sendResponse()
    {
        $this->createResponse();
        $this->beforeResponse();
        $this->prepareKeyboard();
        $this->send();
    }

    /**
     * @return void
     */
    protected function prepareKeyboard(): void
    {
        $preparer = new Base();
        $id = 1;
        foreach ($this->responseMessage as $message) {
            $this->keyboard[$id] = $preparer->prepare($message);
            $id++;
        }
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
        $outboundMessage->inbound_message_id = $this->request['update_id'];
        $outboundMessage->save();

        foreach ($this->responseMessage as &$message) {
            $text = new OutboundMessageText();
            $text->message = $message;
            $text->outboundMessage()->associate($outboundMessage);
            $text->save();
            $message['id'] = $text->id;
        }

        if ($this->command !== null) {
            $context = new OutboundMessageContext();
            $context->outboundMessage()->associate($outboundMessage);
            $context->band()->associate($this->command->getBand());

            if ($this->command->getAlbum() !== null) {
                $context->album()->associate($this->command->getAlbum());
            }

            if ($this->command->getTrack() !== null) {
                $context->track()->associate($this->command->getTrack());
            }

            $context->save();
        }
    }

    /**
     * @return void
     */
    protected function send(): void
    {
        $id = 1;
        foreach ($this->responseMessage as $message) {
            \logger($message);
            $this->telegram->sendMessage([
                'chat_id' => $this->chat->id,
                'text' => $message,
                'parse_mode' => $this->parseMode,
                'reply_markup' => $this->keyboard[$id]
            ]);

            $id++;
        }
    }
}