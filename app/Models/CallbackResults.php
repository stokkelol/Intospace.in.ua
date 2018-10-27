<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CallbackResults
 *
 * @property int $id
 * @property int $outbound_message_id
 * @property string $data
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon updated_at
 *
 * @property-read OutboundMessage $outboundMessage
 *
 * @package App\Models
 */
class CallbackResults extends Model
{
    const TABLE_NAME = 'callback_results';

    /**
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'int',
        'outbound_message_id' => 'int',
    ];

    /**
     * @return BelongsTo
     */
    public function outboundMessage(): BelongsTo
    {
        return $this->belongsTo(OutboundMessage::class);
    }
}