<?php

namespace App\Http\Controllers;

use App\Repositories\Posts\PostRepository;
use App\Repositories\Videos\VideoRepository;
use App\Http\Requests;

/**
 * Class NewsfeedController
 * @package App\Http\Controllers
 */
class NewsfeedController extends Controller
{
    protected $postRepository;
    protected $videoRepository;

    /**
     * NewsfeedController constructor.
     * @param PostRepository $postRepository
     * @param VideoRepository $videoRepository
     */
    public function __construct(
        PostRepository$postRepository,
        VideoRepository $videoRepository
    )
    {
        $this->postRepository = $postRepository;
        $this->videoRepository = $videoRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = [
            'posts'     =>  $this->postRepository->getLatestPublishedPosts(),
            'videos'    =>  $this->videoRepository->getAllVideos()
        ];

        return view('frontend.newsfeed.index', $data);
    }
}
