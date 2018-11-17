<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CallbackResponses;

use App\Bot\ResponseMessages\Interfaces\CallbackResponse;
use App\Bot\ResponseMessages\Response;
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
     * Callback constructor.
     *
     * @param array $data
     * @param Response $response
     */
    public function __construct(array $data, Response $response)
    {
        $this->data = $data;
        $this->response = $response;
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
}