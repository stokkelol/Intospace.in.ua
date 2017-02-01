<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Repositories\PostRepositoryInterface;
use App\Repositories\VideoRepositoryInterface;
use App\Http\Requests;
use App\Video;

class NewsfeedController extends Controller
{
    protected $postRepository;
    protected $videoRepository;

    public function __construct(
                                PostRepositoryInterface $postRepository,
                                VideoRepositoryInterface $videoRepository
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
