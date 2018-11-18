<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CallbackResponses;

/**
 * Class Like
 *
 * @package App\Bot\ResponseMessages\CallbackResponses
 */
class Like extends Callback
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->pivot->likes_count++;
        $this->pivot->save();
        $this->sendTextResponse();
    }

    /**
     * @return string
     */
    protected function getText(): string
    {
        return "Yay! Nice!";
    }
}