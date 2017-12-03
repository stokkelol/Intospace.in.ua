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
     * @var array
     */
    protected $responseMessage;

    /**
     * Factory constructor.
     *
     * @param Api $telegram
     */
    public function __construct(Api $telegram, array $request)
    {
        $this->telegram = $telegram;
        $this->request = $request;
    }
    /**
     * @param $request
     */
    abstract protected function createResponse($request);

    /**
     * @param int $type
     * @param array $request
     * @return TextResponse
     */
    public static function factory(int $type, array $request)
    {
        return new TextResponse(Container::getInstance()->make(Api::class), $request);
    }

    /**
     * @return Response
     */
    public function prepare(): self
    {
        $this->createResponse($this->request);

        return $this;
    }

    /**
     * @return Message
     */
    public function send(): Message
    {
        return $this->telegram->sendMessage($this->responseMessage);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->text;
    }
}