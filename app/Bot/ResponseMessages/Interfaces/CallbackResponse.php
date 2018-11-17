<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\Interfaces;

use Telegram\Bot\Objects\Message;

/**
 * Interface CallbackResponse
 * 
 * @package App\Bot\ResponseMessages\Interfaces
 */
interface CallbackResponse
{
    public function handle(): Message;
}