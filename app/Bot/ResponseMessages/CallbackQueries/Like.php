<?php
declare(strict_types=1);

namespace app\Bot\ResponseMessages\CallbackQueries;

use app\Bot\ResponseMessages\Interfaces\Callback;
use App\Bot\ResponseMessages\Interfaces\Command;
use App\Models\OutboundMessage;

/**
 * Class Like
 *
 * @package app\Bot\ResponseMessages\CallbackQueries
 */
class Like implements Callback
{
    /**
     * @var array
     */
    private $payload = [];

    /**
     * @var OutboundMessage
     */
    private $message;

    /**
     * @var Command
     */
    private $command;

    /**
     * Like constructor.
     *
     * @param OutboundMessage $message
     */
    public function __construct(OutboundMessage $message, Command $command)
    {
        $this->message = $message;
        $this->command = $command;
    }

    /**
     * @return string
     */
    public function prepare(): string
    {
        $this->handle();

        return \json_encode($this->payload);
    }

    /**
     * @return void
     */
    private function handle(): void
    {

    }
}