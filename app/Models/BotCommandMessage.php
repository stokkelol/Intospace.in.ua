<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $inbound_message_id
 * @property int $bot_command_id
 *
 * Class BotCommandMessage
 *
 * @package App\Models
 */
class BotCommandMessage extends Model
{
    const TABLE_NAME = 'bot_command_message';

    /**
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return BelongsTo
     */
    public function inboundMessage(): BelongsTo
    {
        return $this->belongsTo(InboundMessage::class);
    }

    /**
     * @return BelongsTo
     */
    public function botCommand(): BelongsTo
    {
        return $this->belongsTo(BotCommand::class);
    }
}
