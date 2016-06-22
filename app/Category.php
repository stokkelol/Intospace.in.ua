<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use App\Traits\InstanceTrait;
use DB;

class Category extends Model implements SluggableInterface
{
    use SluggableTrait;
    use InstanceTrait;

    protected $sluggable = [
        'build_from'    =>  'title',
        'save_to'       =>  'slug',
        'unique'        =>  true,
    ];

    protected $table = 'categories';

    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }

    public function categoriesWithPostsCount()
    {
        return static::leftJoin('posts', 'posts.category_id', '=', 'categories.id')
            ->groupBy('categories.id')
            ->orderBy('categories.title')
            ->get(['categories.*', DB::raw('COUNT(posts.id) as num')]);
    }

    public function getBySlug($slug)
    {
        return static::where('slug', 'like', $slug)->first();
    }


}
