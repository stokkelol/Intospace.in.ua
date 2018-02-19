<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $social_id
 * @property string $value
 *
 * Class SocialTelegramUser
 *
 * @package App
 */
class SocialTelegramUser extends Model
{
    const TABLE_NAME  = 'social_telegram_user';

    /**
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * @var bool
     */
    public $timestamps = false;
}
