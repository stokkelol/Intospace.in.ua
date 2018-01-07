<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ChatUser
 *
 * @package App
 */
class ChatUser extends Model
{
    const TABLE_NAME = 'chat_user';

    /**
     * @var string
     */
    protected $table = self::TABLE_NAME;
}
