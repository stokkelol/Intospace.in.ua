<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages;

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
     * @return void
     */
    protected function createResponse(): void
    {
        $this->data = \json_decode($this->callback['data'], true);

        $callbackResults = new CallbackResults();
        $callbackResults->outbound_message_id = $this->data['id'];
        $callbackResults->data = $this->callback['data'];
        $callbackResults->save();


    }
}