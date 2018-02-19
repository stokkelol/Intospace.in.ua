<?php
declare(strict_types=1);

namespace app\Bot\Jobs;

use App\Models\BroadcastMessage;
use App\Models\Chat;
use App\Models\MessageType;
use App\Models\OutboundMessage;
use App\Models\TelegramUser;

/**
 * Class BotJob
 *
 * @package app\Bot\Jobs
 */
abstract class BotJob
{
    /**
     * @var TelegramUser
     */
    protected $chat;

    /**
     * @var OutboundMessage
     */
    protected $outboundMessage;

    /**
     * @var BroadcastMessage
     */
    protected $broadcastMessage;

    /**
     * BotJob constructor.
     *
     * @param Chat $chat
     */
    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
    }

    /**
     * @param OutboundMessage $outboundMessage
     * @param BroadcastMessage $broadcastMessage
     * @param TelegramUser $user
     */
    protected function saveMessages(OutboundMessage $outboundMessage, BroadcastMessage $broadcastMessage, TelegramUser $user): void
    {
        $this->outboundMessage = $outboundMessage;
        $this->outboundMessage->chat()->associate($this->chat);
        $this->outboundMessage->user()->associate($user);
        $this->outboundMessage->message_type_id = MessageType::ENTITIES;
        $this->outboundMessage->save();

        $this->broadcastMessage = $broadcastMessage;
        $this->broadcastMessage->user()->associate($user);
        $this->broadcastMessage->chat()->associate($this->chat);
        $this->broadcastMessage->outboundMessage()->associate($this->outboundMessage);
        $this->broadcastMessage->save();
    }
}