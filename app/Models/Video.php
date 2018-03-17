<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Entity;
use App\Traits\ScopesTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Video
 *
 * @package App\Models
 */
class Video extends Entity
{
    use ScopesTrait, Sluggable;

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function band(): BelongsTo
    {
        return $this->belongsTo(Band::class, 'band_id');
    }

    /**
     * @param $slug
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getBySlug($slug): self
    {
        return $this->with(['user'])->where('slug', $slug)->first();
    }

    /**
     * @param Builder $query
     * @param string $slug
     * @return Builder
     */
    public function scopeGetVideosByBandSlug(Builder $query, string $slug): Builder
    {
        return $query->whereHas('band', function ($query) use ($slug) {
            $query->whereSlug($slug);
        });
    }
}
