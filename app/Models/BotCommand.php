<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class BotCommand
 *
 * @package app\Models
 */
class BotCommand extends Model
{
    const LATEST_ID = 1;
    const LATEST = '/latest';

    const BLACK_METAL_ID = 2;
    const BLACK_METAL = '/blackmetal';

    const DEATH_METAL_ID = 3;
    const DEATH_METAL = '/deathmetal';

    const SLUDGE_ID = 4;
    const SLUDGE = '/sludge';

    const TECHNICAL_DEATH_METAL_ID = 5;
    const TECHNICAL_DEATH_METAL = '/technicaldeathmetal';

    const SLUDGE_DOOM_ID = 6;
    const SLUDGE_DOOM = '/sludgedoom';

    const EXPERIMENTAL_ID = 7;
    const EXPERIMENTAL = '/experimental';

    const PSYCHEDELIC_ID = 8;
    const PSYCHEDELIC = '/psychedelic';

    const DOOM_METAL_ID = 9;
    const DOOM_METAL = '/doommetal';

    const YOUTUBE_ID = 10;
    const YOUTUBE = '/youtube';

    const STOP_BROADCASTING_ID = 11;
    const STOP_BROADCASTING = '/stop';

    const START_BROADCASTING_ID = 12;
    const START_BROADCASTING = '/start';

    const HELP_ID = 13;
    const HELP = '/help';

    const TABLE_NAME = 'bot_commands';

    /**
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * @return HasMany
     */
    public function inboundMessages(): HasMany
    {
        return $this->hasMany(InboundMessage::class);
    }
}