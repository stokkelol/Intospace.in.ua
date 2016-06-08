<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use App\Traits\InstanceTrait;
use Cache;

/**
 * App\Post
 *
 * @property-read \App\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Tag[] $tags
 * @property-read mixed $tag_list
 * @property-read \App\Category $category
 * @method static \Illuminate\Database\Query\Builder|\App\Post findBySlug($slug)
 * @method static \Illuminate\Database\Query\Builder|\App\Post byStatus($statuses)
 * @method static \Illuminate\Database\Query\Builder|\App\Post bySearchQuery($search)
 * @method static \Illuminate\Database\Query\Builder|\App\Post recent()
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereSlug($slug)
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $category_id
 * @property integer $user_id
 * @property string $title
 * @property string $excerpt
 * @property string $content
 * @property string $links
 * @property string $video
 * @property string $similar
 * @property string $img
 * @property string $img_thumbnail
 * @property string $logo
 * @property string $slug
 * @property boolean $is_pinned
 * @property boolean $views
 * @property string $status
 * @property \Carbon\Carbon $published_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereExcerpt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereLinks($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereVideo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereSimilar($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereImg($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereImgThumbnail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereLogo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereIsPinned($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereViews($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post wherePublishedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereUpdatedAt($value)
 */
class Post extends Model implements SluggableInterface
{

    use SluggableTrait;
    use InstanceTrait;

    /**
     * @var array
     */
    protected $sluggable = [
        'build_from'    =>  'title',
        'save_to'       =>  'slug',
        'unique'        =>   true,
    ];

    /**
     * @var string
     */
    protected $table = 'posts';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'title',
    ];

    public static $instance = null;

    protected $dates = [
        'created_at',
        'updated_at',
        'published_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function getTagListAttribute()
    {
        return $this->tags->lists('id')->all();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getPostsByCategoryId($category_id)
    {
        $posts = $this->with(['category', 'user']);
        if (!empty($category_id)) {
            $posts = $posts->where('category_id', $category_id);
        }

        return $posts->active()->sort()->paginate(10);
    }

    public function getPostsByCategory($slug)
    {
        $posts = Post::with('tags', 'category')->whereHas('category', function ($query) use ($slug) {
            $query->whereSlug($slug);
        })->latest()->paginate(10);

        return $posts;
    }

    public function getBySlug($slug)
    {
        return $this->with(['user', 'category', 'tags'])->where('slug', $slug)->first();
    }

    public function scopeFindBySlug($query, $slug)
    {
        return $query->whereSlug($slug)->firstOrFail();
    }

    public function scopeByStatus($query, $statuses)
    {
        return $query->where('status', $statuses);
    }

    public function scopeBySearchQuery($query, $search)
    {
        return $query->where('title', 'like', '%'.$search.'%')->orWhere('excerpt', 'like', '%'.$search.'%');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function getPostsByTag($slug)
    {
        $posts = Post::with('tags', 'category')->whereHas('tags', function ($query) use ($slug) {
                                                  $query->whereSlug($slug);})
                                                ->latest()->paginate(10);

        return $posts;
    }
}
