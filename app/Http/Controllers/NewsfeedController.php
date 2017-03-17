<?php

namespace App\Http\Controllers;

use App\Repositories\Posts\PostRepository;
use App\Repositories\Videos\VideoRepository;
use App\Http\Requests;

class NewsfeedController extends Controller
{
    protected $postRepository;
    protected $videoRepository;

    public function __construct(
        PostRepository$postRepository,
        VideoRepository $videoRepository
    )
    {
        $this->postRepository = $postRepository;
        $this->videoRepository = $videoRepository;
    }

    public function index()
    {
        $data = [
            'posts'     =>  $this->postRepository->getLatestPublishedPosts(),
            'videos'    =>  $this->videoRepository->getAllVideos()
        ];

        return view('frontend.newsfeed.index', $data);
    }
}
