<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class OutboundMessageText
 *
 * @package App\Models
 */
class OutboundMessageText extends Model
{
    const TABLE_NAME = 'outbound_message_texts';

    /**
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * @return BelongsTo
     */
    public function outboundMessage(): BelongsTo
    {
        return $this->belongsTo(OutboundMessage::class);
    }
}
