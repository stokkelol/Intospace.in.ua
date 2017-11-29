<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Cviebrock\EloquentSluggable\Sluggable;

/**
 * Class Category
 *
 * @package App
 */
class Category extends Model
{
    use Sluggable;

    /**
     * @var array
     */
    protected $sluggable = [
        'build_from'    =>  'title',
        'save_to'       =>  'slug',
        'unique'        =>  true,
    ];

    /**
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /**
     * @var string
     */
    protected $table = 'categories';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts(): HasMany
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
     * @return static
     */
    public function getBySlug($slug): self
    {
        return static::where('slug', 'like', $slug)->first();
    }


}
