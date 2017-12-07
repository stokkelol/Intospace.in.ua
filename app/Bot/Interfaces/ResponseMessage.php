<?php
declare(strict_types=1);

namespace App\Bot\Interfaces;

use App\Models\Chat;
use App\Models\TelegramUser;

/**
 * Interface ResponseMessage
 *
 * @package app\Bot\Interfaces
 */
interface ResponseMessage
{
    public function sendResponse();

    public function setParameters(array $request, Chat $chat, TelegramUser $user);
}