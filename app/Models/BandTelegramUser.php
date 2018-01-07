<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BandTelegramUser
 *
 * @package App
 */
class BandTelegramUser extends Model
{
    const TABLE_NAME = 'band_telegram_user';

    protected $table = self::TABLE_NAME;
}
