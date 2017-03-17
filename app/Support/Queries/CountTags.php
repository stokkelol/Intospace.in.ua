<?php

namespace App\Support\Queries;

use Illuminate\Support\Facades\DB;
use App\Models\Tag;

class CountTags
{
    public function get($count)
    {
        if (!isset($count)) {
            $count = count(Tag::all());
        }

        $tags = Tag::join('post_tag', 'tags.id', '=', 'post_tag.tag_id')
            ->groupBy('tags.id')
            ->select(['tags.*', DB::raw('COUNT(*) as cnt')])
            ->orderBy('cnt', 'desc')
            ->take($count)
            ->get();

        return $tags;
    }
}
