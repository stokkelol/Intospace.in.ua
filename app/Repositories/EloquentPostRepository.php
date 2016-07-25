<?php

namespace App\Repositories;

use App\Post;
use App\User;
use App\Category;
use App\Repositories\PostRepository;

class EloquentPostRepository implements PostRepository
{
    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function getAllPosts()
    {
        return $this->post->all();
    }

    public function getRandomPosts()
    {
        $randomposts = $this->post->where('status', 'like', 'active')
            ->where('category_id', '=', '1')
            ->get()
            ->random(6);

        return $randomposts;
    }

    public function getPostsByCategory($slug)
    {
        $posts = $this->post->with('tags', 'category')->whereHas('category', function ($query) use ($slug) {
            $query->whereSlug($slug);
        })->latest()->paginate(10);

        return $posts;
    }

    public function getPopularPosts($count)
    {
        $posts = $this->post->with('tags')
            ->whereIn('status', ['active'])
            ->groupBy('views')
            ->orderBy('views', 'desc')
            ->take($count)
            ->get();

        return $posts;
    }

    public function getLatestActivePosts()
    {
        $posts = $this->post->latest()
            ->whereIn('status', ['active'])
            ->take(10)
            ->get();

        return $posts;
    }

    public function getPostsBySearchQuery($query)
    {
        $posts = $this->post->byStatus('active')
            ->where('title', 'like', '%'.$query.'%')
            ->orWhere('excerpt', 'like', '%'.$query,'%')
            ->orWhere('content', 'like', '%'.$query,'%')
            ->groupBy('published_at')
            ->orderBy('published_at', 'desc');

        return $posts;
    }

    public function getLatestPublishedPosts()
    {
        $posts = $this->getActivePosts();

        return $posts;
    }

    public function getRecentPosts($count)
    {
        return $this->post->latest()->take($count);
    }

    public function getShortReviewsPosts()
    {
        $posts = $this->getActivePosts()
            ->where('category_id','=','3')
            ->paginate(15);

        return $posts;
    }

    public function getActivePosts()
    {
        $posts = $this->post->byStatus('active')
            ->groupBy('published_at')
            ->orderBy('published_at', 'desc');

        return $posts;
    }

    public function getPostsByStatus($status)
    {
        $posts = $this->post->byStatus($status)
            ->groupBy('published_at')
            ->orderBy('published_at', 'desc');

        return $posts;
    }

    public function getPostsByUserId($user_id)
    {
        $posts = $this->getActivePosts()->where('user_id', '=', $user_id);

        return $posts;
    }

    public function getPostsByBandSlug($slug)
    {
        $posts = $this->getActivePosts()->whereHas('band', function ($query) use ($slug) {
                                                  $query->whereSlug($slug);})
                                                  ->latest();

        return $posts;
    }

    public function getPinnedPost()
    {
        return $post = $this->getActivePosts()->where('is_pinned', '=', 1);
    }

    public function getMonthlyPosts()
    {
        $posts = $this->post->byStatus('active')->getMonthlyItems()->get();

        return $posts;
    }
}
