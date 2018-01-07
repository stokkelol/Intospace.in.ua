<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
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
}
