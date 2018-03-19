<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Label
 *
 * @package App\Models
 */
class Label extends Model
{
    const TABLE_NAME = 'labels';

    /**
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'int',
        'country_id' => 'int',
        'code' => 'int'
    ];
}
