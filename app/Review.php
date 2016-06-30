<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use AlgoliaSearch\Laravel\AlgoliaEloquentTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Cache;
use App\Traits\FiltersTrait;

class Review extends Model implements SluggableInterface
{
    use SluggableTrait;

    protected $sluggable = [
        'build_from'    =>  'title',
        'save_to'       =>  'slug',
        'unique'        =>   true,
    ];

    protected $table = 'reviews';

    protected $fillable = [
        'id',
        'title',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'published_at'
    ];
}
