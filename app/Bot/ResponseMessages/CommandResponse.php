<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages;

use App\Bot\ResponseMessages\CommandResponses\BlackMetal;
use App\Bot\ResponseMessages\CommandResponses\Latest;
use App\Models\BotCommand;

/**
 * Class CommandResponse
 *
 * @package App\Bot\ResponseMessages
 */
class CommandResponse extends Response
{
    const ENDPOINT = 'https://www.intospace.in.ua/posts/';

    public function createResponse(): void
    {
        $this->determineCommand();
    }

    /**
     * @return mixed
     */
    protected function extractType()
    {
        return $this->request['message']['text'];
    }

    /**
     * @return string
     */
    private function determineCommand()
    {
        $type = $this->extractType();

        if ($type == BotCommand::LATEST) {
            $this->responseMessage = (new Latest())->prepare();
        }

        if ($type == BotCommand::BLACK_METAL) {
            $this->responseMessage = (new BlackMetal())->prepare();
        }
    }
}