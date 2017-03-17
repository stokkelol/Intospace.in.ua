<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

/**
 * Class Band
 * @package App
 */
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
        return $this->hasMany(Post::class, 'band_id');
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
