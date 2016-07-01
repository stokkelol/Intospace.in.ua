<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use DB;

class Band extends Model
{
    protected $sluggable = [
        'build_from'    =>  'band_title',
        'save_to'       =>  'slug',
        'unique'        =>  true,
    ];

    protected $table = 'bands';

    public function posts()
    {
        return $this->hasMany(Post::class, 'band_title');
    }

    public function videos()
    {
        return $this->hasMany(Video::class, 'band_title');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'band_title');
    }
}
