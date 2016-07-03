<?php

namespace App\Repositories;

use App\Post;
use App\User;
use App\Category;
use App\Repositories\PostRepositoryInterface;

class PostRepository implements PostRepositoryInterface
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

    public function getPostsBySearchQuery($query)
    {
        $posts = $this->post->with('category', 'tags', 'user')
                ->where('title', 'like', '%'.$query.'%')
                ->orWhere('excerpt', 'like', '%'.$query,'%')
                ->orWhere('content', 'like', '%'.$query,'%')
                ->where('status', 'like', 'active')
                ->groupBy('published_at')
                ->orderBy('published_at', 'desc')
                ->paginate(15);

        return $posts;
    }

    public function getLatestPublishedPosts()
    {
        $posts = $this->post->with('category', 'tags', 'user')
                ->where('status', 'like', 'active')
                ->groupBy('published_at')
                ->orderBy('published_at', 'desc')
                ->paginate(15);

        return $posts;
    }
}
