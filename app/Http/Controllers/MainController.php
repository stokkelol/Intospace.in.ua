<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Posts\PostRepository;
use App\Repositories\Tags\TagRepository;
use App\Repositories\Videos\VideoRepository;
use App\Video;
use App\Http\Requests;
use DB;
use Input;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class MainController extends Controller
{
    protected $postRepository;
    protected $tagRepository;
    protected $videoRepository;

    /**
     * PostController constructor.
     * @param PostRepository $repository
     */
    public function __construct(PostRepository $postRepository,
                                TagRepository $tagRepository,
                                VideoRepository $videoRepository)
    {
        $this->postRepository = $postRepository;
        $this->tagRepository = $tagRepository;
        $this->videoRepository = $videoRepository;
    }

    public function index(Request $request)
    {
        if ($request->has('search')) {
            return $this->indexSearch($request);
        }

        return $this->indexMain($request);
    }

    public function indexMain(Request $request)
    {
        $posts = $this->getCollection($request);

        $page = $request->get('page', LengthAwarePaginator::resolveCurrentPage());
        $perPage = 15;
        $offSet = ($page * $perPage) - $perPage;
        $items = $posts->slice($offSet, $perPage)->all();

        $links = new LengthAwarePaginator($posts, count($posts), $perPage);
        $links->setPath('/');
        $topPost = $this->postRepository->getPinnedPost()->first();

        $data = [
            'toppost'       =>  $topPost,
            'links'         =>  $links,
            'posts'         =>  $items,
            'tags'          =>  $this->tagRepository->getAllTags(),
            'randposts'     =>  $this->postRepository->getRandomPosts()
        ];

        //dd($data);

        return view('frontend.main', $data);
    }

    public function indexSearch(Request $request)
    {
        $posts = $this->getCollection($request);
        if ($posts->count() == 1) {
            $query = $request->get('search');
            $topPost = $this->postRepository->getPostsBySearchQuery($query)->first();
            $posts = [];
        } else {
            $topPost = [];
        }

        $data = [
            'toppost'       =>  $topPost,
            'posts'         =>  $posts,
            'tags'          =>  $this->tagRepository->getAllTags(),
        ];
        //dd($topPost);
        return view('frontend.main', $data);
    }

    public function getCollection(Request $request)
    {
        if ($request->has('search')) {
            $query = $request->get('search');
            $postscollection = collect($this->postRepository->getPostsBySearchQuery($query)->get());
            $videoscollection = collect($this->videoRepository->getVideosBySearchQuery($query)->get());
            $posts = $postscollection->merge($videoscollection)->sortByDesc('published_at');

            return $posts;
        }

        $postscollection = collect($this->postRepository->getLatestPublishedPosts()->get());
        $videoscollection = collect($this->videoRepository->getLatestVideos()->get());
        $posts = $postscollection->merge($videoscollection)->sortByDesc('published_at');

        return $posts;
    }


    /**
     * Custom 503 page for a little bit of maintenance
     *
     * @return mixed
     */
    public function maintenance()
    {
      return view('errors.503-custom');
    }
}
