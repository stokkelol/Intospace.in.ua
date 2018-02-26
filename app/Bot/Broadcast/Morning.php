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
//        foreach ($this->chats as $chat) {
//            \dispatch(new MorningMessage($chat));
//        }

        $chat = Chat::query()->find(73429990);
        \dispatch(new MorningMessage($chat));
    }
}