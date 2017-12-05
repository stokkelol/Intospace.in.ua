<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages;

use App\Bot\Interfaces\ResponseMessage;
use App\Models\Chat;
use App\Models\MessageType;
use App\Models\TelegramUser;
use Telegram\Bot\Api;

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
     * @var TelegramUser
     */
    protected $user;

    /**
     * @var bool
     */
    protected $responseIsArray = false;

    /**
     * Factory constructor.
     *
     * @param Api $telegram
     */
    public function __construct(Api $telegram, array $request, Chat $chat, TelegramUser $user)
    {
        $this->telegram = $telegram;
        $this->request = $request;
        $this->chat = $chat;
        $this->user = $user;
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
    public static function factory(int $type, array $request, Api $telegram, Chat $chat, TelegramUser $user)
    {
        switch ($type) {
            case MessageType::TEXT:
                return new TextResponse($telegram, $request, $chat, $user);
                break;
            case MessageType::ENTITIES:
                return new CommandResponse($telegram, $request, $chat, $user);
                break;
        }


    }

    /**
     * @return Response
     */
    public function sendResponse()
    {
        return $this->createResponse();
    }
}