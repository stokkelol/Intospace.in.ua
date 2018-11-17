<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CallbackResponses;

/**
 * Class Dislike
 *
 * @package App\Bot\ResponseMessages\CallbackResponses
 */
class Dislike extends Callback
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->sendTextResponse();
    }

    /**
     * @return string
     */
    protected function getText(): string
    {
        return "Ohhh. I'll remember that.";
    }
}