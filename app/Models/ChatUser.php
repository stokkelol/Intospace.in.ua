<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ChatUser
 *
 * @package App
 */
class ChatUser extends Model
{
    const TABLE_NAME = 'chat_user';

    protected $table = self::TABLE_NAME;
}
