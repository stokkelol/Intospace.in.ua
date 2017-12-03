<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages;

use App\Models\BotCommand;

/**
 * Class CommandResponse
 *
 * @package App\Bot\ResponseMessages
 */
class CommandResponse extends Response
{
    public function createResponse()
    {
        $this->determineCommand();

        return $this->send();
    }

    /**
     * @return mixed
     */
    protected function extractType()
    {
        return $this->request['message']['entities'][0]['type'];
    }

    /**
     * @return string
     */
    private function determineCommand()
    {
        $type = $this->extractType();

        if ($type === BotCommand::LATEST) {
            return $this->responseMessage = 'https://www.youtube.com/watch?v=yCUx5WKIZ1E';
        }
    }
}