<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OutboundMessage
 *
 * @package App\Models
 */
class OutboundMessage extends Model
{
    const TABLE_NAME = 'outbound_messages';

    protected $table = self::TABLE_NAME;
}
