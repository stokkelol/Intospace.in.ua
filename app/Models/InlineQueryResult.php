<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class InlineQueryResult
 *
 * @package App
 */
class InlineQueryResult extends Model
{
    const TABLE_NAME = 'inline_queries_relies';

    /**
     * @var string
     */
    protected $table = self::TABLE_NAME;
}
