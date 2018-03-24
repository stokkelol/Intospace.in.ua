<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $mdib
 * @property int $country_id
 * @property string $description
 * @property string $disambiguation
 * @property string $lastfm_url
 * @property string $metal_archives_url
 * @property string $facebook_url
 * @property string $bandcamp_url
 * @property string $soundcloud_url
 * @property int $is_post_exists
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property-read Country $country
 * @property-read \Illuminate\Database\Eloquent\Collection|Album[] $albums
 *
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

    /**
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * @return HasMany
     */
    public function albums(): HasMany
    {
        return $this->hasMany(Album::class);
    }

    /**
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)->wherePivot('value');
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

    /**
     * @return bool
     */
    public function mbidExists(): bool
    {
        return $this->mbid !== null;
    }

    /**
     * @return bool
     */
    public function isPostExists(): bool
    {
        return $this->is_post_exists !== null;
    }
}
