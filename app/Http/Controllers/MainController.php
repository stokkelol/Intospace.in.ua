<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

/**
 * Class MainController
 *
 * @package App\Http\Controllers
 */
class MainController extends Controller
{
    const POSTS_PER_PAGE = 15;

    /**
     * @var Post
     */
    protected $post;

    /**
     * @var Tag

     */
    protected $tag;

    /**
     * @var Video
     */
    protected $video;

    /**
     * MainController constructor.
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
    public function index(Request $request): View
    {
        if ($request->has('search')) {
            return $this->indexSearch($request);
        }

        return $this->indexMain($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexMain(Request $request): View
    {
        $posts = $this->getCollection($request);

        $page = $request->get('page', LengthAwarePaginator::resolveCurrentPage());
        $perPage = static::POSTS_PER_PAGE;
        $offSet = ($page * $perPage) - $perPage;
        $items = $posts->slice($offSet, $perPage)->all();

        $links = new LengthAwarePaginator($posts, count($posts), $perPage);
        $links->setPath('/');
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
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexSearch(Request $request): View
    {
        $posts = $this->getCollection($request);
        if ($posts->count() == 1) {
            $query = $request->get('search');
            $topPost = $this->post->bySearchQuery($query)->first();
            $posts = [];
        } else {
            $topPost = [];
        }

        $data = [
            'toppost' => $topPost,
            'posts' => $posts,
            'tags' => $this->tag->get(),
        ];

        return view('frontend.main', $data);
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

        if (Cache::has('main_posts')) {
            $posts = Cache::get('main_posts');
        } else {
            $posts = $this->post->active()->get();

            Cache::put('main_posts', $posts, 1440);
        }

        if (Cache::has('main_videos')) {
            $videos = Cache::get('main_videos');
        } else {
            $videos = $this->video->with('user', 'band')->latest()->get();

            Cache::put('main_videos', $posts, 1440);
        }

        $postsCollection = collect($posts);
        $videosCollection = collect($videos);

        return $postsCollection->merge($videosCollection)->sortByDesc('published_at');
    }


    /**
     * Custom 503 page for a little bit of maintenance
     *
     * @return View
     */
    public function maintenance(): View
    {
        return view('errors.503-custom');
    }
}
