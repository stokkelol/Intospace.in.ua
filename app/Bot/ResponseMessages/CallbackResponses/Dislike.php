<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CallbackResponses;

use Telegram\Bot\Objects\Message;

/**
 * Class Dislike
 *
 * @package App\Bot\ResponseMessages\CallbackResponses
 */
class Dislike extends Callback
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
        return "Ohhh";
    }
}