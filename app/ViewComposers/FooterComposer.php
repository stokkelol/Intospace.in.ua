<?php
declare(strict_types=1);

namespace App\ViewComposers;

use App\Models\Post;
use Illuminate\Contracts\View\View;

/**
 * Class FooterComposer
 *
 * @package App\ViewComposers
 */
class FooterComposer
{
    /**
     * @var Post
     */
    protected $post;

    /**
     * FooterComposer constructor.
     *
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * @param View $view
     * @return void
     */
    public function compose(View $view): void
    {
        $randompost = $this->post->inRandomOrder()->first();

        $view->with('randompost', $randompost);
    }
}
