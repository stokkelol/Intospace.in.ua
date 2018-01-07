<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BroadcastMessage
 *
 * @package App
 */
class BroadcastMessage extends Model
{
    const TABLE_NAME = 'broadcast_messages';

    /**
     * @var string
     */
    protected $table = self::TABLE_NAME;
}
