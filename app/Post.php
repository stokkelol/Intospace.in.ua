<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use AlgoliaSearch\Laravel\AlgoliaEloquentTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Cache;
use App\Traits\ScopesTrait;

class Post extends Entity implements SluggableInterface
{
    use SluggableTrait;
    use ScopesTrait;

    protected $table = 'posts';

    protected $fillable = ['year'];

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

    public function scopeFindBySlug($query, $slug)
    {
        return $query->whereSlug($slug)->firstOrFail();
    }

    public function getPostsByTag($slug)
    {
        $posts = Post::with('band', 'tags', 'category')->whereHas('tags', function ($query) use ($slug) {
                                                  $query->whereSlug($slug);})
                                                ->latest()->paginate(10);

        return $posts;
    }
}
