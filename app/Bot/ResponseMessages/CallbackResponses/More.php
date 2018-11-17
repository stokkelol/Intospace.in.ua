<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CallbackResponses;

use App\Models\OutboundMessage;

/**
 * Class More
 *
 * @package App\Bot\ResponseMessages\CallbackResponses
 */
class More extends Callback
{
    /**
     * @return void
     */
    public function handle(): void
    {
        /** @var OutboundMessage $previousMessage */
        $previousMessage = OutboundMessage::query()->with("context.band")->where('id', '=', $this->data['id']);
        $service = new \App\Bot\Bands\More($previousMessage->context, $previousMessage->user);
    }

    /**
     * @return string
     */
    protected function getText(): string
    {
        return 'Here you go!';
    }
}