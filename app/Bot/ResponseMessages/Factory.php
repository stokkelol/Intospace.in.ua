<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages;

use App\Bot\Interfaces\ResponseMessage;
use Illuminate\Container\Container;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Message;

/**
 * Class Factory
 *
 * @package App\Bot\ResponseMessages
 */
abstract class Factory
{
    /**
     * @var Api
     */
    protected $telegram;

    /**
     * Factory constructor.
     *
     * @param Api $telegram
     */
    public function __construct(Api $telegram)
    {
        $this->telegram = $telegram;
    }
    /**
     * @param $request
     */
    abstract protected function createResponse($request);

    /**
     * @param int $type
     * @return TextResponse
     */
    public static function factory(int $type)
    {
        return new TextResponse(Container::getInstance()->make(Api::class));
    }

    /**
     * @return Message
     */
    public function create($request)
    {
        $this->createResponse($request);

        return $this->send($this);
    }

    /**
     * @param ResponseMessage $object
     * @return Message
     */
    protected function send(ResponseMessage $object): Message
    {
        return $this->telegram->sendMessage($object);
    }
}