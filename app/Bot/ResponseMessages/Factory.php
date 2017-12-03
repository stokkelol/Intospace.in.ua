<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages;

use Illuminate\Http\JsonResponse;
use Predis\Response\ResponseInterface;
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
     * @param int $type
     */
    abstract protected function createResponse(int $type);

    /**
     * @param int $type
     * @return Message
     */
    public function create(int $type)
    {
        $object = $this->createResponse($type);

        return $this->send($object);
    }

    /**
     * @param ResponseInterface $object
     * @return Message
     */
    protected function send(ResponseInterface $object): Message
    {
        $this->telegram->sendMessage($object);
    }
}