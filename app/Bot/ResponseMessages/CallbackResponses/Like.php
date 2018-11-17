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
    /**
     * @return Message
     */
    public function handle(): Message
    {
        return $this->sendTextResponse();
    }

    /**
     * @return string
     */
    protected function getText(): string
    {
        return "Yay!";
    }
}