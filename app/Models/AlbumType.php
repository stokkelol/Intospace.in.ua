<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class AlbumType
 *
 * @package App\Models
 */
class AlbumType extends Model
{
    const TABLE_NAME = 'album_types';

    /**
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * @return HasMany
     */
    public function albums(): HasMany
    {
        return $this->hasMany(Album::class);
    }
}
