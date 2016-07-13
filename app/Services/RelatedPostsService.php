<?php

namespace App\Services;

use App\Post;

class RelatedPostsService
{
    public function getRelatedPosts($tags, $id)
    {
        $tagsids = $tags->lists('tag');
        $relatedposts = Post::whereHas('tags', function ($query) use ($tagsids) {
            $query->whereIn('tag', $tagsids);
        });

        $relatedposts = $relatedposts->where('id', '<>', $id)->whereIn('status', ['active'])->orderBy('created_at', 'desc')->get()->random(4);

        return $relatedposts;
    }
}
