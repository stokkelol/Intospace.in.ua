<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use DB;

class Band extends Model implements SluggableInterface
{
    use SluggableTrait;

    protected $sluggable = [
        'build_from'    =>  'title',
        'save_to'       =>  'slug',
        'unique'        =>  true,
    ];

    protected $table = 'bands';

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
