<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CallbackQueries;

use App\Models\OutboundMessageText;

/**
 * Class Like
 *
 * @package App\Bot\ResponseMessages\CallbackQueries
 */
class Like extends Query
{
    /**
     * @return void
     */
    public function handle(): void
    {
        /** @var OutboundMessageText $message */
        $message = OutboundMessageText::query()->where('id', $this->data['id'])->first();
        $outMessage = $message->outboundMessage;
        $outMessage->is_liked = true;
        $outMessage->save();
    }
}