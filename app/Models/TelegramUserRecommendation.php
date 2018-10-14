<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $band_id
 * @property int $user_id
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $created_at
 * @property int $is_dispatched
 * @property string $payload
 *
 * @property-read TelegramUser $user
 * @property-read Band $band
 *
 * Class TelegramUserRecommendation
 *
 * @package App\Models
 */
class TelegramUserRecommendation extends Model
{
    const TABLE_NAME = 'telegram_user_recommendations';

    const YOUTUBE_URL = 'https://www.youtube.com/watch?v=';

    const TYPE_PENDING = 0;
    const TYPE_DISPATCHED = 1;
    const TYPE_ARCHIVED = 2;

    /**
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * @var array
     */
    protected $guarded =['id'];

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'int',
        'band_id' => 'int',
        'user_id' => 'int',
        'is_dispatched' => 'bool'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(TelegramUser::class, 'user_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function band(): BelongsTo
    {
        return $this->belongsTo(Band::class, 'band_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function outboundMessage(): BelongsTo
    {
        return $this->belongsTo(OutboundMessage::class);
    }

    /**
     * @return string
     */
    public function getPayload(): string
    {
        $payload = \json_decode($this->payload, true);

        return $this->createYoutubeLink($payload['link']);
    }

    /**
     * @param string $link
     * @return string
     */
    private function createYoutubeLink(string $link): string
    {
        return static::YOUTUBE_URL . $link;
    }
}
