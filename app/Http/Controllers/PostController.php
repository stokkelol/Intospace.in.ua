<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Models\Video;
use App\Support\Services\RelatedPostsService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

/**
 * Class PostController
 *
 * @package App\Http\Controllers
 */
class PostController extends Controller
{
    const POSTS_PER_PAGE = 15;

    /**
     * @var Post
     */
    private $post;

    /**
     * @var Tag
     */
    private $tag;

    /**
     * @var Video
     */
    private $video;

    /**
     * PostController constructor.
     *
     * @param Post $post
     * @param Tag $tag
     * @param Video $video
     */
    public function __construct(Post $post, Tag $tag, Video $video)
    {
        $this->post = $post;
        $this->tag = $tag;
        $this->video = $video;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $posts = $this->getCollection($request);

        $page = $request->get('page', LengthAwarePaginator::resolveCurrentPage());
        $perPage = static::POSTS_PER_PAGE;
        $offSet = ($page * $perPage) - $perPage;
        $items = $posts->slice($offSet, $perPage)->all();

        $links = new LengthAwarePaginator($posts, count($posts), $perPage);
        $links->setPath('/posts');
        $topPost = $this->post->pinned()->first();

        $data = [
            'toppost' => $topPost,
            'links' => $links,
            'posts' => $items,
            'tags' => $this->tag->allWith()->get(),
            'randposts' => $this->post->where('status', 'active')
                ->where('category_id', '=', '1')->inRandomORder()->take(18)->get()
        ];

        return view('frontend.main', $data);
    }


    /**
     * @param $slug
     * @param RelatedPostsService $related
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($slug, RelatedPostsService $related)
    {
        $post = $this->post->findBySlug($slug)->first();

        if ($post === null) {
            App::abort(404);
        }

        $this->incrementViews($post);
        $relatedPosts = $related->getRelatedPosts($post->tags, $post->id);

        $data = [
            'posts' => $relatedPosts,
            'post' => $post,
            'title' => $post->title,
        ];

        return view('frontend.posts.post', $data);
    }

    /**
     * @param $post
     */
    protected function incrementViews($post)
    {
        if ($post->status === 'active') {
            $post->increment('views');
        }
    }

    /**
     * @param Request $request
     * @return Collection
     */
    public function getCollection(Request $request): Collection
    {
        if ($request->has('search')) {
            $query = $request->get('search');
            $postsCollection = collect($this->post->bySearchQuery($query)->get());
            $videosCollection = collect($this->video->bySearchQuery($query)->get());

            return $postsCollection->merge($videosCollection)->sortByDesc('published_at');
        }

        $postsCollection = collect($this->post->active()->get());
        $videosCollection = collect($this->video->with('user', 'band')->latest()->get());

        return $postsCollection->merge($videosCollection)->sortByDesc('published_at');
    }
}
