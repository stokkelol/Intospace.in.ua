<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Support\Facades\DB;

/**
 * Class Category
 * @package App
 */
class Category extends Model implements SluggableInterface
{
    use SluggableTrait;

    /**
     * @var array
     */
    protected $sluggable = [
        'build_from'    =>  'title',
        'save_to'       =>  'slug',
        'unique'        =>  true,
    ];

    /**
     * @var string
     */
    protected $table = 'categories';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }

    /**
     * @return mixed
     */
    public function categoriesWithPostsCount()
    {
        return $this->leftJoin('posts', 'posts.category_id', '=', 'categories.id')
            ->groupBy('categories.id')
            ->orderBy('categories.title')
            ->get(['categories.*', DB::raw('COUNT(posts.id) as num')]);
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function getBySlug($slug)
    {
        return static::where('slug', 'like', $slug)->first();
    }


}
