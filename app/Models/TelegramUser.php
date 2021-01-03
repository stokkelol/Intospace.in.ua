<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $user_name
 * @property string $language_code
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
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
            'chat_user', 'user_id', 'chat_id')
            ->withPivot('active');
    }

    /**
     * @return BelongsToMany
     */
    public function socials(): BelongsToMany
    {
        return $this->belongsToMany(Social::class,
            'social_telegram_user', 'user_id', 'social_id')
            ->withPivot('value');
    }

    /**
     * @return BelongsToMany
     */
    public function bands(): BelongsToMany
    {
        return $this->belongsToMany(Band::class,
            'band_telegram_user', 'user_id', 'band_id')
            ->withPivot('value', 'lastfm_count');
    }

    /**
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class,
            'tag_telegram_user', 'user_id', 'tag_id')
            ->withPivot('value');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recommendations()
    {
        return $this->hasMany(TelegramUserRecommendation::class, 'user_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    |  Other methods
    |--------------------------------------------------------------------------
    */

    /**
     * @param int $count
     * @return Collection
     */
    public function getTopBands(int $count): Collection
    {
        return $this->bands()->orderBy('lastfm_count')->take($count)->get();
    }

    /**
     * @return TelegramUserRecommendation
     */
    public function getLatestRecommendation(): TelegramUserRecommendation
    {
        return $this->recommendations()->where('is_dispatched', false)->orderBy('id', 'desc')->first();
    }

    /**
     * @return bool
     */
    public function isLastfmExists(): bool
    {
        return $this->socials()->wherePivot('social_id', '=', Social::LASTFM)->exists();
    }

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
    public function routeNotificationForSlack()
    {
        return config('slack.webhook');
    }
}
