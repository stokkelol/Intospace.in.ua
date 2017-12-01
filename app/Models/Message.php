<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Message
 *
 * @package App
 */
class Message extends Model
{
    const TABLE_NAME = 'messages';

    protected $table = self::TABLE_NAME;
}
