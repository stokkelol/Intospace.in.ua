<?php

namespace App\Http\Controllers;

use App\Repositories\Posts\PostRepository;
use App\Models\Post;
use App\Http\Requests;

/**
 * Class ShortReviewController
 * @package App\Http\Controllers
 */
class ShortReviewController extends Controller
{
    protected $post;

    /**
     * ShortReviewController constructor.
     * @param PostRepository $post
     */
    public function __construct(PostRepository $post)
    {
        $this->post = $post;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = [
            'posts' =>  $this->post->getShortReviewsPosts(),
        ];

        return view('frontend.shortreviews.index', $data);
    }
}
