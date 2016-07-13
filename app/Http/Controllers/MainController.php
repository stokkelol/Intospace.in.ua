<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PostRepositoryInterface;
use App\Repositories\TagRepositoryInterface;
use App\Repositories\VideoRepositoryInterface;
use App\Video;
use App\Http\Requests;
use DB;
use Input;
use Illuminate\Pagination\LengthAwarePaginator;

class MainController extends Controller
{
    protected $postRepository;
    protected $tagRepository;
    protected $videoRepository;

    /**
     * PostController constructor.
     * @param PostRepository $repository
     */
    public function __construct(PostRepositoryInterface $postRepository,
                                TagRepositoryInterface $tagRepository,
                                VideoRepositoryInterface $videoRepository)
    {
        $this->postRepository = $postRepository;
        $this->tagRepository = $tagRepository;
        $this->videoRepository = $videoRepository;
    }

    public function index(Request $request)
    {

        if ($request->has('search')) {
          $query = $request->get('search');
          $postscollection = collect($this->postRepository->getPostsBySearchQuery($query));
        } else {
          $postscollection = collect($this->postRepository->getActivePosts()->get());
        }
        $videoscollection = collect($this->videoRepository->getLatestVideos());

        $postss = $postscollection->merge($videoscollection)->sortByDesc('published_at');
        //dd($postss);

        $page = Input::get('page', 1);
        $perPage = 15;
        $offSet = ($page * $perPage) - $perPage;
        $items = $postss->slice($offSet, $perPage)->all();

        $posts = new LengthAwarePaginator($items, count($items), $perPage);

        $data = [
            'posts'         =>  $posts,
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
