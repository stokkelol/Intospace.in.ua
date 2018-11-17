<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CallbackResponses;

use App\Models\BandTelegramUser;
use App\Models\OutboundMessage;

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
        /** @var OutboundMessage $previousMessage */
        $previousMessage = OutboundMessage::query()->with("context.band")->where('id', '=', $this->data['id']);
        /** @var BandTelegramUser $pivot */
        $pivot = BandTelegramUser::query()->where("user_id", '=', $this->response->getUser()->id)
            ->where('band_id', '=', $previousMessage->context->band->id)->first();

        if ($pivot !== null) {
            $pivot->likes_count++;
        } else {
            $pivot = new BandTelegramUser();
            $pivot->user()->associate($this->response->getUser());
            $pivot->band()->associate($previousMessage->context->band);
            $pivot->likes_count++;
            $pivot->lastfm_count = null;
        }

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