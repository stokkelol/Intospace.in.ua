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

    public function handle(): array
    {
        return [$this->getText()];
    }

    /**
     * @return string
     */
    protected function getText(): string
    {
        return "Yay!";
    }
}