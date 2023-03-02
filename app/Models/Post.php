<?php
declare(strict_types=1);

namespace App\Models;

use App\Traits\ScopesTrait;
use App\Core\Entity;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
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

    public function scopeGetPostsByBandSlug(Builder $query, string $slug): Builder
    {
        return $query->whereHas('band', function ($query) use ($slug) {
            $query->whereSlug($slug);
        });
    }

    /**
     * @param $query
     * @param $slug
     * @return mixed
     */
    public function scopeFindBySlug(Builder $query, string $slug): Builder
    {
        return $query->whereSlug($slug);
    }

    /**
     * @param Builder $query
     * @param int $take
     * @return Builder
     */
    public function scopeRecent(Builder $query, int $take): Builder
    {
        return $query->latest()->take($take);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->with('tags', 'user', 'band', 'category')->where('status', '=', 'active');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeLatest(Builder $query): Builder
    {
        return $query->active()->orderBy('id')->take(10);
    }

    /**
     * @param Builder $query
     * @param string $img
     * @return Builder
     */
    public function scopeByImage(Builder $query, string $img): Builder
    {
        return $query->where('img', '=', $img);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeRandom(Builder $query): Builder
    {
        return $query->where('status', 'active')
            ->where('category_id', '=', '1');
    }

    public function scopePopular(Builder $query, int $count): Builder
    {
        return $query->active()
            ->groupBy('views')
            ->orderBy('views', 'desc')
            ->take($count);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopePinned(Builder $query): Builder
    {
        return $query->where('is_pinned', '=', 1);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeGetShortReviews(Builder $query): Builder
    {
        return $query->active()->where('category_id','=','3');
    }

    public function scopeGetPostsBySearchQuery($query)
    {
        return $query->byStatus('active')
            ->where('title', 'like', '%' . $query . '%')
            ->orWhere('excerpt', 'like', '%' . $query . '%')
            ->orWhere('content', 'like', '%' . $query . '%')
            ->groupBy('published_at')
            ->orderBy('published_at', 'desc');
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
