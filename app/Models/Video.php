<?php

namespace App\Models;

use App\Models\Band;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use App\Traits\ScopesTrait;
use App\Core\Entity;

class Video extends Entity implements SluggableInterface
{
    use SluggableTrait;
    use ScopesTrait;

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
