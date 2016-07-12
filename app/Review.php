<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use AlgoliaSearch\Laravel\AlgoliaEloquentTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Cache;

class Review extends Entity implements SluggableInterface
{
    use SluggableTrait;

    protected $table = 'reviews';

    public function band()
    {
        return $this->belongsTo(Band::class, 'band_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
