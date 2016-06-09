<?php

namespace App\Services;

use App\Post;

class BlogService
{
    public function getRelatedPosts($tags)
    {
        $tagsids = $tags->lists('tag');
        $relatedposts = Post::whereHas('tags', function ($query) use ($tagsids) {
            $query->whereIn('tag', $tagsids);
        });

        $relatedposts = $relatedposts->orderBy('created_at', 'desc')->take(4)->get();

        return $relatedposts;
    }
}
