<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PostRepository;
use App\Repositories\TagRepository;
use App\Repositories\VideoRepository;
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
          $query = $request->get('search');
          $postscollection = collect($this->postRepository->getPostsBySearchQuery($query)->get());
          $videoscollection = collect($this->videoRepository->getVideosBySearchQuery($query)->get());
        } else {
          $postscollection = collect($this->postRepository->getActivePosts()->get());
          $videoscollection = collect($this->videoRepository->getLatestVideos());
        }

        $posts = $postscollection->merge($videoscollection)->sortByDesc('published_at');

        $page = $request->get('page', LengthAwarePaginator::resolveCurrentPage());
        $perPage = 15;
        $offSet = ($page * $perPage) - $perPage;
        $items = $posts->slice($offSet, $perPage)->all();

        $links = new LengthAwarePaginator($posts, count($posts), $perPage);
        $links->setPath('/');

        $data = [
            'links'         =>  $links,
            'posts'         =>  $items,
            'tags'          =>  $this->tagRepository->getAllTags(),
            'randposts'     =>  $this->postRepository->getRandomPosts()
        ];

        return view('frontend.main', $data);
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
