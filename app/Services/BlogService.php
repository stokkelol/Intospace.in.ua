<?php

namespace App\Services;

use App\Post;

class BlogService
{
    public function getRelatedPosts($tags)
    {
        $number = 4;

        $tagsids = $tags->lists('tag');
        $relatedposts = Post::whereHas('tags', function ($query) use ($tagsids) {
            $query->whereIn('tag', $tagsids);
        });

        $relatedposts = $relatedposts->orderBy('created_at')->take($number)->get();

        return $relatedposts;
    }
}
