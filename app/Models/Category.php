<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
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

    const TABLE_NAMES = 'categories';

    /**
     * @var string
     */
    protected $table = self::TABLE_NAMES;

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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'category_id');
    }

    /**
     * @return Collection
     */
    public function categoriesWithPostsCount(): Collection
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
