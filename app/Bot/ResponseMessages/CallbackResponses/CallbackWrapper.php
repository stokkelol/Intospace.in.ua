<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CallbackResponses;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\RequestException;
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
     * @var array
     */
    private $params;

    /**
     * CallbackWrapper constructor.
     * @param Api $telegram
     * @param TelegramRequest $request
     */
    public function __construct(Api $telegram, TelegramRequest $request, array $params)
    {
        $this->client = new Client();
        $this->request = $request;
        $this->telegram = $telegram;
        $this->params = $params;
    }

    public function send()
    {
        $endpoint = $this->telegram->getClient()->getBaseBotUrl() . $this->telegram->getAccessToken() . '/' . $this->request->getEndpoint();
        try {
            $this->client->post($endpoint, $this->params);
        } catch (RequestException $e) {
            \logger("Exception: " . $e->getMessage());
        } catch (\Throwable $e) {
            \logger("Exception: " . $e->getCode() . $e->getMessage());
        }
    }
}