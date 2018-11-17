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
     * @return void
     * @throws \LogicException
     */
    public function createResponse(): void
    {
        $messages = $this->handle();

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
     * @throws \LogicException
     */
    private function handle()
    {
        $this->setCommand(Factory::build($this->extractType(), $this->user));

        if (!$this->command) {
            throw new LogicException('Command is not set');
        }

        return $this->command->prepare();
    }

    /**
     * @return Command
     */
    public function getCommand(): Command
    {
        return $this->command;
    }

    /**
     * @return void
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    protected function send(): void
    {
        $counter = 1;
        foreach ($this->responseMessage as $message) {
            $this->telegram->sendMessage([
                'chat_id' => $this->chat->id,
                'text' => $message,
                'parse_mode' => $this->parseMode,
                'reply_markup' => \json_encode([
                        'inline_keyboard' => $this->keyboard[$counter],
                        'resize_keyboard' => true,
                        'one_time_keyboard' => true
                    ]
                )
            ]);

            $counter++;
        }
    }
}