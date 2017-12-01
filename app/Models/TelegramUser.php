<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TelegramUser
 *
 * @package App
 */
class TelegramUser extends Model
{
    const TABLE_NAME = 'telegram_users';

    protected $table = self::TABLE_NAME;
}
