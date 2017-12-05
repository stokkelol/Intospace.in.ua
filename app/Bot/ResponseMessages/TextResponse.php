<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages;

/**
 * Class TextResponse
 *
 * @package app\Bot\ResponseMessages
 */
class TextResponse extends Response
{
    public function createResponse()
    {
        $this->responseMessage = 'Silence is golden!';

        return $this->telegram->sendMessage([
            'chat_id' => $this->chat->id,
            'text' => $this->responseMessage
        ]);
    }
}