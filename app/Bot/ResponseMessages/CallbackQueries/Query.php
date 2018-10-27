<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CallbackQueries;

use App\Bot\ResponseMessages\Interfaces\Callback;
use App\Models\OutboundMessageText;

/**
 * Class Query
 *
 * @package App\Bot\ResponseMessages\CallbackQueries
 */
abstract class Query implements Callback
{
    /**
     * @var array
     */
    protected $data;

    /**
     * Query constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param string $field
     */
    protected function save(string $field): void
    {
        /** @var OutboundMessageText $message */
        $message = OutboundMessageText::query()->where('id', $this->data['id'])->first();
        $outMessage = $message->outboundMessage;
        $outMessage->{$field} = true;
        $outMessage->save();
    }
}