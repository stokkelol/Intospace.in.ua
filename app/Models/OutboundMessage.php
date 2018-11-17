<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $message_type_id
 * @property int $user_id
 * @property int $chat_id
 * @property int $inbound_message_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property bool $is_liked
 * @property bool $is_disliked
 *
 * @property-read OutboundMessageContext $context
 * @property-read TelegramUser $user
 * @property-read Chat $chat
 * @property-read MessageType $messageType
 * @property-read \Illuminate\Database\Eloquent\Collection|OutboundMessageText[] $texts
 *
 * Class OutboundMessage
 *
 * @package App\Models
 */
class OutboundMessage extends Model
{
    const TABLE_NAME = 'outbound_messages';

    /**
     * @var string
     */
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

    /**
     * @return HasOne
     */
    public function context(): HasOne
    {
        return $this->hasOne(OutboundMessageContext::class);
    }

    /**
     * @return HasOne
     */
    public function recommendation(): HasOne
    {
        return $this->hasOne(TelegramUserRecommendation::class);
    }
}
