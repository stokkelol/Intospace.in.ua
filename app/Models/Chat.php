<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Chat
 *
 * @package App
 */
class Chat extends Model
{
    const TABLE_NAME = 'chats';

    protected $table = self::TABLE_NAME;
}
