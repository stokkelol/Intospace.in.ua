<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $band_id
 * @property int $value
 *
 * Class TagTelegramUser
 *
 * @package App\Models
 */
class TagTelegramUser extends Model
{
    const TABLE_NAME = 'tag_telegram_user';

    /**
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var bool
     */
    public $timestamps = false;
}
