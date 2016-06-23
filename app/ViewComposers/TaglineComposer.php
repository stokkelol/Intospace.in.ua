<?php

namespace App\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Tag;

class TaglineComposer
{
    protected $_tag;

    public function __construct(Tag $tag)
    {
        $this->_tag = $tag;
    }

    public function compose(View $view)
    {
        $tags = $this->_tag->countTags()->take(10);

        $view->with('tags', $tags);
    }
}
