<?php

namespace App\Repositories;

use App\Repositories\TagRepositoryInterface;
use App\Tag;

class TagRepository implements TagRepositoryInterface
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
