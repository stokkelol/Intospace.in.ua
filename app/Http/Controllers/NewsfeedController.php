<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Video;

/**
 * Class NewsfeedController
 *
 * @package App\Http\Controllers
 */
class NewsfeedController extends Controller
{
    protected $post;
    protected $video;

    /**
     * NewsfeedController constructor.
     *
     * @param Post $post
     * @param Video $video
     */
    public function __construct(Post $post, Video $video)
    {
        $this->post = $post;
        $this->video = $video;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = [
            'posts' => $this->post->active()->get(),
            'videos' => $this->video->get()
        ];

        return view('frontend.newsfeed.index', $data);
    }
}
