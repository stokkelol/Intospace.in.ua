<?php
declare(strict_types=1);

namespace App\ViewComposers;

use App\Models\MonthlyReview;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Video;
use App\Support\Queries\CountTags;
use Illuminate\Contracts\View\View;

/**
 * Class NavbarComposer
 *
 * @package App\ViewComposers
 */
class NavbarComposer
{
    /**
     * @var Post
     */
    protected $post;

    /**
     * @var Video
     */
    protected $video;

    /**
     * @var Tag
     */
    protected $tag;

    /**
     * @var MonthlyReview
     */
    protected $review;

    /**
     * NavbarComposer constructor.
     *
     * @param Post $post
     * @param Video $video
     * @param Tag $tag
     * @param MonthlyReview $review
     */
    public function __construct(Post $post, Video $video, Tag $tag, MonthlyReview $review)
    {
        $this->post = $post;
        $this->video = $video;
        $this->tag = $tag;
        $this->review = $review;
    }

    /**
     * @param View $view
     * @return void
     */
    public function compose(View $view): void
    {
        $view->with('navbarposts', $this->post->latest()->active()->get())
             ->with('navbarvideos', $this->video->latest()->get())
             ->with('counttags', (new CountTags)->get(20))
             ->with('reviews', $this->review->get());
    }
}
