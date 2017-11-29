<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Repositories\Posts\PostRepository;
use App\Repositories\Tags\TagRepository;
use App\Repositories\Videos\VideoRepository;
use Illuminate\Pagination\LengthAwarePaginator;
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
     * @var PostRepository
     */
    protected $post;

    /**
     * @var TagRepository
     */
    protected $tag;

    /**
     * @var VideoRepository
     */
    protected $video;

    /**
     * MainController constructor.
     *
     * @param PostRepository $postRepository
     * @param TagRepository $tagRepository
     * @param VideoRepository $videoRepository
     */
    public function __construct(
        PostRepository $postRepository,
        TagRepository $tagRepository,
        VideoRepository $videoRepository
    )
    {
        $this->post = $postRepository;
        $this->tag = $tagRepository;
        $this->video = $videoRepository;
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
        $topPost = $this->post->getPinnedPost()->first();

        $data = [
            'toppost'       =>  $topPost,
            'links'         =>  $links,
            'posts'         =>  $items,
            'tags'          =>  $this->tag->getAllTags(),
            'randposts'     =>  $this->post->getRandomPosts()
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
            $topPost = $this->post->getPostsBySearchQuery($query)->first();
            $posts = [];
        } else {
            $topPost = [];
        }

        $data = [
            'toppost' => $topPost,
            'posts' => $posts,
            'tags' => $this->tag->getAllTags(),
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
            $postscollection = collect($this->post->getPostsBySearchQuery($query)->get());
            $videoscollection = collect($this->video->getVideosBySearchQuery($query)->get());
            $posts = $postscollection->merge($videoscollection)->sortByDesc('published_at');

            return $posts;
        }

        $postscollection = collect($this->post->getLatestPublishedPosts()->get());
        $videoscollection = collect($this->video->getLatestVideos()->get());
        $posts = $postscollection->merge($videoscollection)->sortByDesc('published_at');

        return $posts;
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
