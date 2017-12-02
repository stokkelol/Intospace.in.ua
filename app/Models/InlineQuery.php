<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class InlineQuery
 *
 * @package App
 */
class InlineQuery extends Model
{
    const TABLE_NAME = 'inline_queries';

    protected $table = self::TABLE_NAME;
}
