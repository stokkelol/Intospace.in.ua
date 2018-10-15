<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CallbackQueries;

use App\Models\OutboundMessage;

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
        /** @var OutboundMessage $message */
        logger("message id : " . $this->data['id']);
        $message = OutboundMessage::query()->where('id', $this->data['id'])->first();
        $message->is_liked = true;
        $message->save();
    }
}