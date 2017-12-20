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
}