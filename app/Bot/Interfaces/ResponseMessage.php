<?php
declare(strict_types=1);

namespace App\Bot\Interfaces;

use Telegram\Bot\Objects\Message;

/**
 * Interface ResponseMessage
 *
 * @package app\Bot\Interfaces
 */
interface ResponseMessage
{
    public function prepare(array $request);

    public function send(ResponseMessage $object): Message;
}