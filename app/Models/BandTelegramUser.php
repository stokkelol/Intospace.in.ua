<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $band_id
 * @property int $value
 *
 * Class BandTelegramUser
 *
 * @package App
 */
class BandTelegramUser extends Model
{
    const TABLE_NAME = 'band_telegram_user';

    /**
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * @var array
     */
    protected $guarded = ['id'];
}
