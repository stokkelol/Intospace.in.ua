<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;

/**
 * Class ShortReviewController
 *
 * @package App\Http\Controllers
 */
class ShortReviewController extends Controller
{
    protected $post;

    /**
     * ShortReviewController constructor.
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = [
            'posts' =>  $this->post->getShortReviewsPosts()->paginate(15)
        ];

        return view('frontend.shortreviews.index', $data);
    }
}
