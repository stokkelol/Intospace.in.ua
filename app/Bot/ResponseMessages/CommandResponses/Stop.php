<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CommandResponses;

use App\Bot\ResponseMessages\Interfaces\Command;

/**
 * Class Stop
 * 
 * @package App\Bot\ResponseMessages\CommandResponses
 */
class Stop extends BaseCommand implements Command
{
    /**
     * @return array
     */
    public function prepare(): array
    {
        $this->user->chats()->update(['active' => false]);

        return [
            'OK! Now I will no longer send you messages! Just type anything again and I will be right here!'
        ];
    }
}