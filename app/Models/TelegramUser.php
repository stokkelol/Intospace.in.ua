<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read \Illuminate\Database\Eloquent\Collection|Chat[] $chats
 * @property-read \Illuminate\Database\Eloquent\Collection|Social[] $socials
 * @property-read \Illuminate\Database\Eloquent\Collection|Band[] $bands
 * Class TelegramUser
 *
 * @package App
 */
class TelegramUser extends Model
{
    const TABLE_NAME = 'telegram_users';

    /**
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'int',
    ];

    /*
    |--------------------------------------------------------------------------
    |  Relations
    |--------------------------------------------------------------------------
    */

    /**
     * @return BelongsToMany
     */
    public function chats(): BelongsToMany
    {
        return $this->belongsToMany(Chat::class,
            'chat_user', 'user_id', 'chat_id');
    }

    /**
     * @return BelongsToMany
     */
    public function socials(): BelongsToMany
    {
        return $this->belongsToMany(Social::class,
            'social_telegram_user', 'user_id', 'social_id');
    }

    /**
     * @return BelongsToMany
     */
    public function bands(): BelongsToMany
    {
        return $this->belongsToMany(Band::class);
    }
}
