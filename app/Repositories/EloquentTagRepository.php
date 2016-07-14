<?php

namespace App\Repositories;

use App\Repositories\TagRepository;
use App\Tag;
use App\Post;
use App\User;
use DB;

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

    public function countTags()
    {
        $tags = $this->tag->join('post_tag', 'tags.id', '=', 'post_tag.tag_id')
            ->groupBy('tags.id')
            ->select(['tags.*', DB::raw('COUNT(*) as cnt')])
            ->orderBy('cnt', 'desc')
            ->get();

        return $tags;
    }
}