<?php
declare(strict_types=1);

namespace App\Bot\Broadcast;

use App\Bot\Jobs\MorningMessage;
use App\Models\Chat;

/**
 * Class Morning
 *
 * @package App\Bot\Broadcast
 */
class Morning extends BaseBroadcast
{
    /**
     * @return void
     * @throws \InvalidArgumentException
     */
    public function handle(): void
    {
        var_dump(__METHOD__);
        /** @var Chat $chat */
        foreach ($this->chats as $chat) {
            if ($chat->isActive()) {
                \dispatch(new MorningMessage($chat));
                \logger($chat->id);
            }
        }
    }
}