<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Models\Video;

class BackendController extends Controller
{
    /**
     * @var Post
     */
    private $post;

    /**
     * @var Video
     */
    private $video;

    /**
     * @var User
     */
    private $user;

    /**
     * BackendController constructor.
     * @param Post $post
     * @param Video $video
     * @param User $user
     */
    public function __construct(Post $post, Video $video, User $user)
    {
        $this->post = $post;
        $this->video = $video;
        $this->user = $user;
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'posts_total' => $this->post->count(),
            'posts_active' => $this->post->active()->count(),
            'posts_draft' => $this->post->byStatus('draft')->count(),
            'posts_moderation' => $this->post->byStatus('moderation')->count(),
            'recent_posts' => $this->post->latest()->take(5)->get(),
            'popular_posts' => $this->post->popular(5),
            'videos_total' => $this->video->count(),
            'users_total' => $this->user->count()
        ];

        return view('backend.main', $data);
    }
}
