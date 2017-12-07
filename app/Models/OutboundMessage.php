<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class OutboundMessage
 *
 * @package App\Models
 */
class OutboundMessage extends Model
{
    const TABLE_NAME = 'outbound_messages';

    protected $table = self::TABLE_NAME;

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(TelegramUser::class, 'user_id');
    }

    /**
     * @return BelongsTo
     */
    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }

    /**
     * @return BelongsTo
     */
    public function messageType(): BelongsTo
    {
        return $this->belongsTo(MessageType::class, 'message_type_id');
    }

    /**
     * @return HasMany
     */
    public function texts(): HasMany
    {
        return $this->hasMany(OutboundMessageText::class);
    }
}
