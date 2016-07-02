<?php

namespace App\Repositories;

use App\Tag;

class TagRepository
{
    protected $tag;

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function getAllTags()
    {
        $tags = $this->tag->with('posts')
                ->groupBy('tag')
                ->orderBy('tag', 'asc')
                ->get();

        return $tags;
    }
}
