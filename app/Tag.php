<?php

namespace App;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\InstanceTrait;
use Cache;
use DB;

class Tag extends Model implements SluggableInterface
{

    use SluggableTrait;
    use InstanceTrait;

    protected $sluggable = [
        'build_from'    =>  'tag',
        'save_to'       =>  'slug',
        'unique'        => true,
    ];

    protected $table = 'tags';
    protected $fillable = ['tag', 'id'];
    public static $instance = null;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tag', 'post_id', 'tag_id');
    }

    public function scopeFindBySlug($query, $slug)
    {
        return $query->whereSlug($slug)->firstOrFail();
    }

    public function setSlugAttribute($tag)
    {
        if (str_slug($tag) != '') {
            $this->attributes['slug'] = str_slug($tag);
        } else {
            $this->attributes['slug'] = $tag;
        }
    }

    public function getBySlug($slug)
    {
        return static::where('slug', 'like', $slug)->first();
    }

}
