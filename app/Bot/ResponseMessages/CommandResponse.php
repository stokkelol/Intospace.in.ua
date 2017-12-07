<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages;

use app\Bot\ResponseMessages\CommandResponses\BlackMetal;
use app\Bot\ResponseMessages\CommandResponses\Latest;
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
        \logger($type);
        \logger($this->responseMessage);
        if ($type == BotCommand::LATEST) {
            $this->responseMessage = (new BlackMetal())->prepare();
        }

        if ($type == BotCommand::BLACK_METAL) {
            $this->responseMessage = (new Latest())->prepare();
        }
    }
}