<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Chat
 *
 * @package App
 */
class Chat extends Model
{
    const TABLE_NAME = 'chats';

    protected $table = self::TABLE_NAME;

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(TelegramUser::class, 'chat_user', 'chat_id', 'user_id');
    }
}
