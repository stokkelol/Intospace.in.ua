<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Album
 *
 * @package App\Models
 */
class Album extends Model
{
    const TABLE_NAME = 'albums';

    protected $table = self::TABLE_NAME;

    /**
     * @return BelongsTo
     */
    public function band(): BelongsTo
    {
        return $this->belongsTo(Band::class);
    }
}
