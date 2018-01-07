<?php
declare(strict_types=1);

namespace App\Support\Queries;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\Tag;

/**
 * Class CountTags
 *
 * @package App\Support\Queries
 */
class CountTags
{
    /**
     * @param $count
     * @return Collection
     */
    public function get($count): Collection
    {
        if (!isset($count)) {
            $count = Tag::query()->count();
        }

        $tags = Tag::query()->join('post_tag', 'tags.id', '=', 'post_tag.tag_id')
            ->groupBy('tags.id')
            ->select(['tags.*', DB::raw('COUNT(*) as cnt')])
            ->orderBy('cnt', 'desc')
            ->take($count)
            ->get();

        return $tags;
    }
}
