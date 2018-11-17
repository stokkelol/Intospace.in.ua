<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages;

use App\Bot\ResponseMessages\TextResponses\Parser;

/**
 * Class TextResponse
 *
 * @package app\Bot\ResponseMessages
 */
class TextResponse extends Response
{
    /**
     * @return void
     */
    public function createResponse(): void
    {
        $this->responseMessage = (new Parser($this))->parse();
    }

    /**
     * @return void
     */
    protected function send(): void
    {
        $counter = 1;
        foreach ($this->responseMessage as $message) {
            $this->telegram->sendMessage([
                'chat_id' => $this->chat->id,
                'text' => $message,
                'parse_mode' => $this->parseMode,
                'reply_markup' => \json_encode([
                        'inline_keyboard' => $this->keyboard[$counter],
                        'resize_keyboard' => true,
                        'one_time_keyboard' => true
                    ]
                )
            ]);

            $counter++;
        }
    }
}