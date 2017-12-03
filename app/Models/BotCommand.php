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

    const TABLE_NAME = 'bot_commands';

    protected $table = self::TABLE_NAME;
}