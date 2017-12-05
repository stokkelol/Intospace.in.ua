<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages;

use App\Bot\Interfaces\ResponseMessage;
use App\Models\Chat;
use App\Models\MessageType;
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
    protected $responseMessage;

    /**
     * Factory constructor.
     *
     * @param Api $telegram
     */
    public function __construct(Api $telegram, array $request, Chat $chat)
    {
        $this->telegram = $telegram;
        $this->request = $request;
        $this->chat = $chat;
    }
    /**
     * @return void
     */
    abstract protected function createResponse();

    /**
     * @param int $type
     * @param array $request
     * @param Api $telegram
     * @return ResponseMessage
     */
    public static function factory(int $type, array $request, Api $telegram, Chat $chat)
    {
        switch ($type) {
            case MessageType::TEXT:
                return new TextResponse($telegram, $request, $chat);
                break;
            case MessageType::ENTITIES:
                return new CommandResponse($telegram, $request, $chat);
                break;
        }


    }

    /**
     * @return Response
     */
    public function prepare(): self
    {
        $this->createResponse();

        return $this;
    }

    /**
     * @return Message
     */
    public function send(): Message
    {
        \logger($this->responseMessage);

        return $this->telegram->sendMessage([
            'chat_id' => $this->chat->id,
            'text' => $this->responseMessage
        ]);
    }
}