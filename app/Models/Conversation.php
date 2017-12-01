<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Conversation
 *
 * @package App
 */
class Conversation extends Model
{
    const TABLE_NAME = 'conversations';

    protected $table = self::TABLE_NAME;
}
