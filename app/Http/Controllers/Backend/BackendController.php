<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\Posts\PostRepository;
use App\Repositories\Users\UserRepository;
use App\Repositories\Categories\CategoryRepository;
use Auth;
use DB;
use App\Repositories\Videos\VideoRepository;
use App\Http\Requests;
use LaravelAnalytics;

class BackendController extends Controller
{
    protected $post;
    protected $video;
    protected $user;

    public function __construct(PostRepository $postRepository,
                                VideoRepository $videoRepository,
                                UserRepository $userRepository)
    {
        $this->post = $postRepository;
        $this->video = $videoRepository;
        $this->user = $userRepository;
    }

    public function index()
    {
        $data = [
            'title'                 =>  'Dashboard',
            'posts_total'           =>  $this->post->getAllPosts()->count(),
            'posts_active'          =>  $this->post->getActivePosts()->count(),
            'posts_draft'           =>  $this->post->getPostsByStatus('draft')->count(),
            'posts_moderation'      =>  $this->post->getPostsByStatus('moderation')->count(),
            'recent_posts'          =>  $this->post->getRecentPosts(5)->get(),
            'popular_posts'         =>  $this->post->getPopularPosts(5),
            'videos_total'          =>  $this->video->getAllVideos()->count(),
            'users_total'           =>  $this->user->getAllUsers()->count()
        ];

        return view('backend.main', $data);
    }
}
