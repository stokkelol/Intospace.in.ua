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
    public function createResponse(): void
    {
        $this->responseMessage = 'Silence is golden!';
    }
}