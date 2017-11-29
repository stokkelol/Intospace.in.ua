<?php

namespace App\Models;

use App\Models\Band;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Traits\ScopesTrait;
use App\Core\Entity;

class Video extends Entity
{
    use ScopesTrait, Sluggable;

    public function sluggable()
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
    public function band()
    {
        return $this->belongsTo(Band::class, 'band_id');
    }

    /**
     * @param $slug
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getBySlug($slug)
    {
        return $this->with(['user'])->where('slug', $slug)->first();
    }
}
