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

    public function handle(): array
    {
        return [$this->getText()];
    }

    /**
     * @return string
     */
    protected function getText(): string
    {
        return "Ohhh";
    }
}