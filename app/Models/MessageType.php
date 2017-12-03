<?php
declare(strict_types=1);

namespace App;

use App\Models\InboundMessage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class MessageType
 *
 * @package App
 */
class MessageType extends Model
{
    const TABLE_NAME = 'message_types';

    const TEXT = 1;
    const ENTITIES = 2;
    const AUDIO = 3;
    const DOCUMENT = 4;
    const PHOTO = 5;
    const STICKER = 6;
    const VIDEO = 7;
    const VOICE = 8;
    const VIDEO_NOTE = 9;
    const CONTACT = 10;
    const LOCATION = 11;
    const VENUE = 12;
    const CAPTION = 13;

    protected $table = self::TABLE_NAME;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(InboundMessage::class);
    }
}
