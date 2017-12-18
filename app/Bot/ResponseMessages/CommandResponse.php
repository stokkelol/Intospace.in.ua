<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages;

use App\Bot\ResponseMessages\CommandResponses\Factory;
use App\Bot\ResponseMessages\Interfaces\Command;
use LogicException;

/**
 * Class CommandResponse
 *
 * @package App\Bot\ResponseMessages
 */
class CommandResponse extends Response
{
    const ENDPOINT = 'https://www.intospace.in.ua/posts/';

    /**
     * @var Command
     */
    private $command;

    /**
     * @return void
     */
    public function createResponse(): void
    {
        $messages = $this->determineCommand();

        if (\is_array($messages)) {
            $this->responseMessage = $messages;
        } else {
            $this->responseMessage[] = $messages;
        }
    }

    /**
     * @param Command $command
     */
    public function setCommand(Command $command): void
    {
        $this->command = $command;
    }

    /**
     * @return mixed
     */
    protected function extractType()
    {
        return $this->request['message']['text'];
    }

    /**
     * @return array
     */
    private function determineCommand()
    {
        $this->setCommand(Factory::build($this->extractType()));

        if (!$this->command) {
            throw new LogicException('Command is not set');
        }

        return $this->command->prepare();
    }
}