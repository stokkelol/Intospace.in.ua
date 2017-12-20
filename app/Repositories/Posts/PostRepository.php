<?php
declare(strict_types=1);

namespace App\Repositories\Posts;

use App\Models\Post;
use App\Support\CustomCollections\CollectionByIds;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class PostRepository
 *
 * @package App\Repositories\Posts
 */
class PostRepository
{
    const STATUS_ACTIVE = 'active';
    const STATUS_MODERATION = 'moderation';
    const STATUS_DELETED = 'deleted';
    const STATUS_REFUSED = 'refused';
    const STATUS_DRAFT = 'draft';

    /**
     * @var Post
     */
    protected $post;

    /**
     * PostRepository constructor.
     *
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllPosts(): Collection
    {
        return $this->post->all();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRandomPosts(): Collection
    {
        $randomposts = $this->post->where('status', 'active')
            ->where('category_id', '=', '1')
            ->get()
            ->random(18);

        return $randomposts;
    }

    public function getBySlug($slug)
    {
        return $this->post->with(['user', 'category', 'tags'])->where('slug', $slug)->first();
    }

    public function getPostsByCategory($slug)
    {
        $posts = $this->getActivePosts()->whereHas('category', function ($query) use ($slug) {
            $query->whereSlug($slug);
        })->latest();

        return $posts;
    }

    /**
     * @param $count
     * @return Collection|\Illuminate\Support\Collection
     */
    public function getPopularPosts($count): Collection
    {
        $posts = $this->post->with('tags')
            ->whereIn('status', ['active'])
            ->groupBy('views')
            ->orderBy('views', 'desc')
            ->take($count)
            ->get();

        return $posts;
    }

    /**
     * @param int $limit
     * @return Collection|\Illuminate\Support\Collection
     */
    public function getLatestActivePosts($limit = 10): Collection
    {
        $posts = $this->post->latest()
            ->whereIn('status', ['active'])
            ->take($limit)
            ->get();

        return $posts;
    }

    public function getPostsBySearchQuery($query)
    {
        $posts = $this->post->search($query)->groupBy('published_at')->orderBy('published_at', 'desc');

        if ($posts === null) {
            $posts = $this->post->byStatus('active')
                ->where('title', 'like', '%' . $query . '%')
                ->orWhere('excerpt', 'like', '%' . $query . '%')
                ->orWhere('content', 'like', '%' . $query . '%')
                ->groupBy('published_at')
                ->orderBy('published_at', 'desc');
        }

        return $posts;
    }

    public function getLatestPublishedPosts()
    {
        return $this->getActivePosts();
    }

    public function getRecentPosts($count)
    {
        return $this->post->latest()->take($count);
    }

    public function getShortReviewsPosts()
    {
        return $this->getActivePosts()
            ->where('category_id','=','3')
            ->paginate(15);
    }

    public function getActivePosts()
    {
        return $this->post->byStatus('active')
            ->groupBy('published_at')
            ->orderBy('published_at', 'desc');
    }

    public function getPostsByStatus($status)
    {
        return $this->post->byStatus($status)
            ->groupBy('published_at')
            ->orderBy('published_at', 'desc');
    }

    public function getPostsByUserId($user_id)
    {
        return $this->getActivePosts()->where('user_id', '=', $user_id);
    }

    public function getPostsById($post_id)
    {
        return (new CollectionByIds($this->post))->find($post_id);
    }

    public function getPostsByBandSlug($slug)
    {
        $posts = $this->getActivePosts()->whereHas('band', function ($query) use ($slug) {
            $query->whereSlug($slug);
        })->latest();

        return $posts;
    }

    public function getPinnedPost()
    {
        return $this->getActivePosts()->where('is_pinned', '=', 1);
    }

    /**
     * @return Collection
     */
    public function getMonthlyPosts(): Collection
    {
        $posts = $this->post->byStatus('active')
            ->getMonthlyItems()
            ->groupBy('published_at')
            ->orderBy('published_at', 'desc')
            ->get();

        return $posts;
    }

    /**
     * @param $img
     * @return Post
     */
    public function getPostByImg($img): Post
    {
        return $this->post->where('img', '=', $img)->first();
    }

    /**
     * @return Post
     */
    public function getBlackMetal(): Post
    {
        return $this->post->whereHas('tags', function ($query) {
            $query->where('tag', 'black metal');
        })->inRandomOrder()->first();
    }

    /**
     * @param string $tag
     * @return Post
     */
    public function getRandomPostByTag(string $tag): Post
    {
        return $this->post->whereHas('tags', function ($query) use ($tag) {
            $query->where('tag', $tag);
        })->inRandomOrder()->first();
    }
}
