<?php
declare(strict_types=1);

namespace App\Bot\Wrappers;

use GuzzleHttp\Client;
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
     * @param array $params
     */
    public function __construct(Api $telegram, array $params)
    {
        $this->client = new Client();
        $this->telegram = $telegram;
        $this->params = $params;
    }

    public function send()
    {
        $request = new TelegramRequest([
            $this->telegram->getAccessToken(),
            'POST',
            'answerCallbackQuery',
            ['callback_query_id' => $this->params['callback_query']['id']]
        ]);
        $endpoint = $this->telegram->getClient()->getBaseBotUrl() . $this->telegram->getAccessToken() . '/answerCallbackQuery';
        try {
            $this->client->post($endpoint, $this->params);
        } catch (RequestException $e) {
            \logger("Exception: " . $e->getMessage());
        } catch (\Throwable $e) {
            \logger("Exception: " . $e->getCode() . $e->getMessage());
        }
    }
}