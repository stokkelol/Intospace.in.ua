<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $id
 * @property $band_id
 * @property $related_id
 * @property $ratio
 *
 * Class BandSimilarity
 *
 * @package App\Models
 */
class BandSimilarity extends Model
{
    const TABLE_NAME = 'band_similarity';

    /**
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * @var bool
     */
    public $timestamps = false;
}
