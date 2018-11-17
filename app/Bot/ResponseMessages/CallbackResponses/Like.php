<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CallbackResponses;

use Telegram\Bot\Objects\Message;

/**
 * Class Like
 *
 * @package App\Bot\ResponseMessages\CallbackResponses
 */
class Like extends Callback
{

    public function handle(): Message
    {
        return $this->response->getApi()->sendMessage([
            'chat_id' => $this->response->getChat()->id,
            'text' => $this->getText(),
            'parse_mode' => $this->response->getParseMode(),

        ]);
    }

    /**
     * @return string
     */
    protected function getText(): string
    {
        return "Yay!";
    }
}