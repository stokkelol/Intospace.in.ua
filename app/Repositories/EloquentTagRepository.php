<?php

namespace App\Repositories;

use App\Repositories\TagRepository;
use App\Tag;
use App\Post;
use App\User;

class EloquentTagRepository implements TagRepository
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
