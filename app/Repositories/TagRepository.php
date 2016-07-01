<?php

namespace App\Repositories;

use App\Tag;

class TagRepository
{
        public function getAllTags()
        {
            $tags = Tag::with('posts')
                    ->groupBy('tag')
                    ->orderBy('tag', 'asc')
                    ->get();

            return $tags;
        }
}
