<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use App\Traits\InstanceTrait;
use Cache;

class Post extends Model implements SluggableInterface
{

    use SluggableTrait;
    use InstanceTrait;

    /**
     * Sluggable
     *
     * @var array
     */
    protected $sluggable = [
        'build_from'    =>  'title',
        'save_to'       =>  'slug',
        'unique'        =>   true,
    ];

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * Fillable
     *
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
     * Post belongs to user by id
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the tags associated with the given post
     *
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
     * Post belongs to one category
     *
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

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function getPostsByTag($slug)
    {
        $posts = Post::with('tags', 'category')->whereHas('tags', function ($query) use ($slug) {
            $query->whereSlug($slug);
        })->latest()->paginate(10);

        return $posts;
    }
}
