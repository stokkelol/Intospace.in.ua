<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $abbreviation
 *
 * Class Country
 *
 * @package App\Models
 */
class Country extends Model
{
    const TABLE_NAME = 'countries';

    /**
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'int'
    ];

    /**
     * @var bool
     */
    public $timestamps = false;
}
