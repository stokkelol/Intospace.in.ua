<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use AlgoliaSearch\Laravel\AlgoliaEloquentTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Cache;

class Post extends Entity implements SluggableInterface
{
    use SluggableTrait;

    protected $table = 'posts';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function getTagListAttribute()
    {
        return $this->tags->lists('id')->all();
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function band()
    {
        return $this->belongsTo(Band::class, 'band_id');
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

    public function getPostsByTag($slug)
    {
        $posts = Post::with('tags', 'category')->whereHas('tags', function ($query) use ($slug) {
                                                  $query->whereSlug($slug);})
                                                ->latest()->paginate(10);

        return $posts;
    }

    public function setPostStatus(Post $_post, $post_id, $status)
    {
        $post = $_post->find($post_id);
        $post->status = $status;
        $post->save();

        return $post;
    }

    public function getPopularPosts()
    {
        return $this->with('tags')
            ->whereIn('status', ['active'])
            ->groupBy('views')
            ->orderBy('views', 'desc')
            ->take(10)
            ->get();
    }

    public function getLatestActivePosts()
    {
        return $this->latest()
            ->whereIn('status', ['active'])
            ->take(10)
            ->get();
    }
}
