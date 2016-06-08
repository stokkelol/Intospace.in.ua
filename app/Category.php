<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use App\Traits\InstanceTrait;
use DB;

/**
 * App\Category
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Post[] $posts
 * @method static \Illuminate\Database\Query\Builder|\App\Category whereSlug($slug)
 * @mixin \Eloquent
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Category whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Category whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Category whereUpdatedAt($value)
 */
class Category extends Model implements SluggableInterface
{
    /**
     * Categories model
     */
    use SluggableTrait;
    use InstanceTrait;

    protected $sluggable = [
        'build_from'    =>  'title',
        'save_to'       =>  'slug',
        'unique'        =>  true,
    ];

    /**
     * Categories table name
     *
     * @var string
     */
    protected $table = 'categories';
    public static $instance = null;

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
