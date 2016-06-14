<?php

namespace App\Repositories;

use App\Post;
use App\Tag;
use App\User;
use App\Category;

class PostRepository
{
    public function getRandomPosts()
    {
        $randomposts = Post::all()
                ->whereIn('status', ['active'])
                //->whereIn('category_id', ['1'])
                ->random(6);

        return $randomposts;
    }

    public function getPostsBySearchQuery($query)
    {
        $posts = Post::with('category', 'tags', 'user')
                ->where('title', 'like', '%'.$query.'%')
                ->orWhere('excerpt', 'like', '%'.$query,'%')
                ->where('status', 'like', 'active')
                ->groupBy('published_at')
                ->orderBy('published_at', 'desc')
                ->paginate(15);

        return $posts;
    }

    public function getLatestPublishedPosts()
    {
        $posts = Post::with('category', 'tags', 'user')
                ->whereIn('status', ['active'])
                ->groupBy('published_at')
                ->orderBy('published_at', 'desc')
                ->paginate(15);

        return $posts;
    }

    public function getAllTags()
    {
        $tags = Tag::with('posts')
                ->groupBy('tag')
                ->orderBy('tag', 'asc')
                ->get();

        return $tags;
    }
}
