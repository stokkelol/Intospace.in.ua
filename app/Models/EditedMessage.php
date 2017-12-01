<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EditedMessage
 *
 * @package App
 */
class EditedMessage extends Model
{
    const TABLE_NAME = 'edited_messages';

    protected $table = self::TABLE_NAME;
}
