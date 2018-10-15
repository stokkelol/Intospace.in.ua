<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CallbackQueries;

use App\Models\OutboundMessage;

/**
 * Class Dislike
 *
 * @package App\Bot\ResponseMessages\CallbackQueries
 */
class Dislike extends Query
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $messageId = $this->data['id'];

        $message = OutboundMessage::query()->find($messageId);
        $message->is_disliked = true;
        $message->save();
    }
}