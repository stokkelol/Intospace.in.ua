<?php
declare(strict_types=1);

namespace App\Bot\Jobs;

use App\Bot\ResponseMessages\CommandResponses\BaseCommand;
use App\Bot\ResponseMessages\CommandResponses\StatisticGatherer;
use App\Models\BroadcastMessage;
use App\Models\MessageType;
use App\Models\OutboundMessage;
use App\Models\OutboundMessageText;

/**
 * Trait Saver
 *
 * @package App\Bot\Jobs
 */
trait Saver
{
    /**
     * @return void
     */
    protected function saveMessages(): void
    {
        $outboundMessage = new OutboundMessage();
        $outboundMessage->chat()->associate($this->chat);
        $outboundMessage->user()->associate($this->user);
        $outboundMessage->message_type_id = MessageType::ENTITIES;
        $outboundMessage->save();

        $outboundMessageText = new OutboundMessageText();
        $outboundMessageText->outboundMessage()->associate($outboundMessage);
        $outboundMessageText->message = $this->message;
        $outboundMessageText->save();

        $broadcastMessage = new BroadcastMessage();
        $broadcastMessage->user()->associate($this->user);
        $broadcastMessage->chat()->associate($this->chat);
        $broadcastMessage->outboundMessage()->associate($outboundMessage);
        $broadcastMessage->save();

        $gatherer = new StatisticGatherer();
        $gatherer->associateBandAndUser($this->post, $this->user, $this->recommendation);
        $gatherer->associateTagAndUser($this->post, $this->user, $this->recommendation);
    }
}