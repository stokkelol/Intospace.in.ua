<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CallbackResponses;

use GuzzleHttp\Client;
use Telegram\Bot\Api;
use Telegram\Bot\TelegramRequest;

/**
 * Class CallbackWrapper
 *
 * @package App\Bot\ResponseMessages\CallbackResponses
 */
class CallbackWrapper
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var TelegramRequest
     */
    private $request;
    /**
     * @var Api
     */
    private $telegram;

    /**
     * CallbackWrapper constructor.
     * @param Api $telegram
     * @param TelegramRequest $request
     */
    public function __construct(Api $telegram, TelegramRequest $request)
    {
        $this->client = new Client();
        $this->request = $request;
        $this->telegram = $telegram;
    }

    public function send()
    {
        $endpoint = $this->telegram->getClient()->getBaseBotUrl() . $this->telegram->getAccessToken() . '/' . $this->request->getEndpoint();
        $params = $this->request->getParams();
        $this->client->post($endpoint, $params);
    }
}