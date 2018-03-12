<?php
declare(strict_types=1);

namespace App\Models;

use App\Traits\ScopesTrait;
use App\Core\Entity;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property int $category_id
 * @property int $user_id
 * @property string $title
 * @property int $year
 * @property int $band_id
 * @property string $excerpt
 * @property string $content
 * @property string $links
 * @property string $video
 * @property string $similar
 * @property string $img
 * @property string $img_thumbnail
 * @property string $logo
 * @property string $slug
 * @property int $is_pinned
 * @property int $views
 * @property string $status
 * @property \DateTime $published_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|Tag[] $tags
 * @property-read Band $band
 *
 * Class Post
 *
 * @package App\Models
 */
class Post extends Entity
{
    use ScopesTrait, Sluggable;

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
    protected $table = 'posts';

    /**
     * @var array
     */
    protected $fillable = ['year'];

    /**
     * @var array
     */
    protected $searchableColumns = ['title'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    /**
     * @return mixed
     */
    public function getTagListAttribute()
    {
        return $this->tags->lists('id')->all();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function band(): BelongsTo
    {
        return $this->belongsTo(Band::class, 'band_id');
    }

    /**
     * @param $category_id
     * @return Collection
     */
    public function getPostsByCategoryId($category_id): Collection
    {
        $posts = $this->with(['category', 'user']);
        if (!empty($category_id)) {
            $posts = $posts->where('category_id', $category_id);
        }

        return $posts->active()->sort()->paginate(10);
    }

    /**
     * @param $query
     * @param $slug
     * @return mixed
     */
    public function scopeFindBySlug($query, $slug)
    {
        return $query->whereSlug($slug)->firstOrFail();
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function getPostsByTag($slug)
    {
        $posts = Post::with('band', 'tags', 'category')
            ->whereHas('tags', function ($query) use ($slug) {
                $query->whereSlug($slug);
            })->latest()->paginate(10);

        return $posts;
    }
}
