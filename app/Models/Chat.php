<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $type
 * @property string $title
 * @property string $name
 * @property int $is_all_admin
 * @property int $old_chat_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|TelegramUser[] $users
 *
 * Class Chat
 *
 * @package App
 */
class Chat extends Model
{
    const TABLE_NAME = 'chats';

    /**
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            TelegramUser::class,
            'chat_user',
            'chat_id',
            'user_id'
        )->withPivot('active');
    }
}
