<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    const DEATH_METAL_id = 3;
    const DEATH_METAL = '/deathmetal';

    const SLUDGE_ID = 4;
    const SLUDGE = '/sludge';

    const TECHNICAL_DEATH_METAL_ID = 5;
    const TECHNICAL_DEATH_METAL = '/technicaldeathmetal';

    const SLUDGE_DOOM_ID = 6;
    const SLUDGE_DOOM = '/sludgedoom';

    const EXPERIMENTAL_ID = 7;
    const EXPERIMENTAL = '/experimental';

    const PSYCHEDELIC_ID = 9;
    const PSYCHEDELIC = '/psychedelic';

    const DOOM_METAL_ID = 10;
    const DOOM_METAL = '/doommetal';

    const TABLE_NAME = 'bot_commands';

    protected $table = self::TABLE_NAME;
}