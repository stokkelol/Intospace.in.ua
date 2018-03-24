<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $band_id
 * @property string $mbid
 * @property \Carbon\Carbon $release_date
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $type_id
 * @property int $label_id
 * @property string $catalog_number
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|Track[] $tracks
 * @property-read Band $band
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

    /**
     * @return HasMany
     */
    public function tracks(): HasMany
    {
        return $this->hasMany(Track::class);
    }
}
