<?php

namespace App\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Repositories\Tags\TagRepository;
use App\Support\Queries\CountTags;

class TaglineComposer
{
    protected $tag;

    public function __construct(TagRepository $tag)
    {
        $this->tag = $tag;
    }

    public function compose(View $view)
    {
        $tags = (new CountTags)->get(10);

        $view->with('tags', $tags);
    }
}
