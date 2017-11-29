<?php

namespace App\Repositories\Tags;

use App\Models\Tag;

class TagRepository
{
    protected $tag;

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function getAllTags()
    {
        $tags = $this->tag->with('posts', 'user')
            ->groupBy('tag')
            ->orderBy('tag', 'asc')
            ->get();

        return $tags;
    }
}
