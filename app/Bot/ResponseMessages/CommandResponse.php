<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages;

use app\Bot\ResponseMessages\CommandResponses\Factory;
use app\Bot\ResponseMessages\Interfaces\Command;

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
        $this->determineCommand();
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
            throw new \LogicException('Command is not set');
        }

        return $this->command->prepare();
    }
}