<?php

namespace App\Support\Services;

use App\Post;

class RelatedPostsService
{
    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function getRelatedPosts($tags, $id)
    {
        $tagsids = $tags->lists('tag');
        $relatedposts = $this->post->whereHas('tags', function ($query) use ($tagsids) {
            $query->whereIn('tag', $tagsids);
        });

        $relatedposts = $relatedposts->where('id', '<>', $id)
            ->whereIn('status', ['active'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->random(12);

        return $relatedposts;
    }
}
