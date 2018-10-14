<?php
/**
 * Created by PhpStorm.
 * User: alexandergulyiy
 * Date: 10/7/18
 * Time: 7:19 PM
 */

namespace App\Bot\ResponseMessages\CallbackQueries;


use App\Bot\ResponseMessages\Interfaces\Callback;
use App\Bot\ResponseMessages\Interfaces\Command;
use App\Models\OutboundMessage;

class Dislike implements Callback
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
     * @param Command $command
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