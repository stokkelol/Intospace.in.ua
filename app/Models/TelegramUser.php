<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;

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
    use Notifiable;
    
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
            'chat_user', 'user_id', 'chat_id')->withPivot('active');
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

    /*
    |--------------------------------------------------------------------------
    |  Other methods
    |--------------------------------------------------------------------------
    */

    /**
     * @return Collection
     */
    public function getActiveChats(): Collection
    {
        return $this->chats()->wherePivot('active', '=', true)->get();
    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    public function routeNotificationForSlack($notification)
    {
        return config('slack.webhook');
    }
}
