<?php
declare(strict_types=1);

namespace App\Support\Services;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class RelatedPostsService
 *
 * @package App\Support\Services
 */
class RelatedPostsService
{
    /**
     * @var Post
     */
    protected $post;

    /**
     * RelatedPostsService constructor.
     *
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * @param $tags
     * @param $id
     * @return Collection
     */
    public function getRelatedPosts($tags, $id): Collection
    {
        $tagsids = $tags->pluck('tag');
        $relatedposts = $this->post->whereHas('tags', function ($query) use ($tagsids) {
            $query->whereIn('tag', $tagsids);
        });

        $relatedposts = $relatedposts->where('id', '<>', $id)
            ->whereIn('status', ['active'])
            ->orderBy('created_at', 'desc')
            ->get();

        if(count($relatedposts) > 24) {
            return $relatedposts->random(24);
        }

        return $relatedposts;
    }
}
