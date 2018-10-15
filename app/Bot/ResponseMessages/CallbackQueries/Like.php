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
        $message = OutboundMessage::query()->find($this->data['id']);
        $message->is_liked = true;
        $message->save();
    }
}