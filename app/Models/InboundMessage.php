<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Message
 *
 * @package App
 */
class InboundMessage extends Model
{
    const TABLE_NAME = 'messages';

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
        'user_id' => 'int',
        'chat_id' => 'int',
        'message_type_id' => 'int',
    ];

    /**
     * @return BelongsToMany
     */
    public function messageType(): BelongsToMany
    {
        return $this->belongsToMany(MessageType::class);
    }
}
