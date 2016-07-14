<?php

namespace App\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Repositories\TagRepository;

class TaglineComposer
{
    protected $_tag;

    public function __construct(TagRepository $tag)
    {
        $this->_tag = $tag;
    }

    public function compose(View $view)
    {
        $tags = $this->_tag->countTags()->take(10);

        $view->with('tags', $tags);
    }
}
