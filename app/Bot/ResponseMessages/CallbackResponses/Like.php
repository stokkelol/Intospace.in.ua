<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CallbackResponses;

use App\Models\BandTelegramUser;
use App\Models\OutboundMessageText;

/**
 * Class Like
 *
 * @package App\Bot\ResponseMessages\CallbackResponses
 */
class Like extends Callback
{
    /**
     * @return void
     */
    public function handle(): void
    {
        /** @var OutboundMessageText $previousMessage */
        $previousMessage = OutboundMessageText::query()->with("outboundMessage.context")->find($this->data['id']);
        /** @var BandTelegramUser $pivot */
        $pivot = BandTelegramUser::query()->where("user_id", '=', $this->response->getUser()->id)
            ->where('band_id', '=', $previousMessage->outboundMessage->context->band_id)->first();
        \logger($pivot->id);
        if ($pivot === null) {
            $pivot = new BandTelegramUser();
            $pivot->user()->associate($this->response->getUser());
            $pivot->band()->associate($previousMessage->outboundMessage->context->band);
            $pivot->lastfm_count = null;
        }
        $pivot->likes_count++;
        $pivot->save();
        $this->sendTextResponse();
    }

    /**
     * @return string
     */
    protected function getText(): string
    {
        return "Yay! Nice!";
    }
}