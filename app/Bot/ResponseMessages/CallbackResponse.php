<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages;

use App\Bot\Wrappers\CallbackWrapper;
use App\Bot\ResponseMessages\CallbackResponses\Factory;
use App\Models\CallbackResults;

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

        $this->handler = Factory::build($this->data['callback_type'], $this->data, $this);
    }

    /**
     * @return void
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    protected function send(): void
    {
        $this->handler->handle();
    }
}