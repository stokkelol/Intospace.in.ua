<?php

namespace App\ViewComposers;

use App\Models\Post;
use Illuminate\Contracts\View\View;

class FooterComposer
{
    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function compose(View $view)
    {
        $randompost = $this->post->inRandomOrder()->first();

        $view->with('randompost', $randompost);
    }
}
