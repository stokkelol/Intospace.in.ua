<?php
declare(strict_types=1);

namespace App\Bot\Broadcast;

use App\Bot\Jobs\MorningMessage;
use App\Models\BroadcastMessage;
use App\Models\Chat;
use App\Models\OutboundMessage;

/**
 * Class Morning
 *
 * @package App\Bot\Broadcast
 */
class Morning extends BaseBroadcast
{
    /**
     * @return void
     */
    public function handle(): void
    {
        foreach ($this->chats as $chat) {
            \dispatch(new MorningMessage($chat, new OutboundMessage(), new BroadcastMessage()));
        }
    }
}