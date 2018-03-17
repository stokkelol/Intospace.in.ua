<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * Class Band
 *
 * @package App
 */
class Band extends Model
{
    use Sluggable;

    /**
     * @var string
     */
    protected $table = 'bands';

    /**
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Relations
    |--------------------------------------------------------------------------
    */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'band_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }

    /**
     * @return BelongsToMany
     */
    public function telegramUsers(): BelongsToMany
    {
        return $this->belongsToMany(TelegramUser::class);
    }

    /**
     * @return BelongsToMany
     */
    public function similars():BelongsToMany
    {
        return $this->belongsToMany(__CLASS__, 'band_similarity', 'band_id', 'related_id');
    }

    /*
    |--------------------------------------------------------------------------
    |  Other methods
    |--------------------------------------------------------------------------
    */

    /**
     * @param string $title
     * @return self
     */
    public function firstByTitle(string $title): self
    {
        return $this->where('title', '=', $title)->first();
    }
}
