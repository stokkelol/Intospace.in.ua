<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages;

use App\Bot\ResponseMessages\CallbackResponses\CallbackWrapper;
use App\Bot\ResponseMessages\CallbackResponses\Factory;
use App\Models\CallbackResults;
use Telegram\Bot\TelegramRequest;

/**
 * Class CallbackResponse
 *
 * @package App\Bot\ResponseMessages
 */
class CallbackResponse extends Response
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @var \App\Bot\ResponseMessages\Interfaces\CallbackResponse
     */
    private $handler;

    /**
     * @return void
     */
    protected function createResponse(): void
    {
        $this->data = \json_decode($this->callback['data'], true);

        $callbackResults = new CallbackResults();
        $callbackResults->id = $this->callback['id'];
        $callbackResults->outbound_message_text_id = $this->data['id'];
        $callbackResults->data = $this->callback['data'];
        $callbackResults->save();

        $this->handler = Factory::build($this->data['callback_type'], $this->data);
    }

    /**
     * @return void
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    protected function send(): void
    {
        $params = [
            'callback_query_id' => (string)$this->callback['id'],
                'text' => $this->handler->handle()[0],
                'cache_time' => 10,
                'show_alert' => true
            ];
        $response = new TelegramRequest(
            $this->telegram->getAccessToken(),
            'POST',
            'answerCallbackQuery',
            [],
            $this->telegram->isAsyncRequest()
        );

        (new CallbackWrapper($this->telegram, $response, $params))->send();
    }
}