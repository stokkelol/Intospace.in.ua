<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read Band $band
 * @property-read Album $album
 * @property-read Track $track
 * @property-read OutboundMessage $outboundMessage
 *
 * Class OutboundMessageContext
 *
 * @package App\Models
 */
class OutboundMessageContext extends Model
{
    const TABLE_NAME = 'outbound_message_contexts';

    /**
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'int',
        'outbound_message_id' => 'int',
        'band_id' => 'int',
        'album_id' => 'int',
        'track_id' => 'int'
    ];

    /**
     * @return BelongsTo
     */
    public function outboundMessage(): BelongsTo
    {
        return $this->belongsTo(OutboundMessage::class);
    }

    /**
     * @return BelongsTo
     */
    public function band(): BelongsTo
    {
        return $this->belongsTo(Band::class);
    }

    /**
     * @return BelongsTo
     */
    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }

    /**
     * @return BelongsTo
     */
    public function track(): BelongsTo
    {
        return $this->belongsTo(Track::class);
    }
}
