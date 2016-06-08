<?php

namespace App\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Post;
use App\Tag;
use App\Video;
use DB;

class SidebarComposer
{
    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $posts = Post::latest()->take(10)->get();
        $videos = Video::latest()->take(10)->get();
        $counttags = Tag::join('post_tag', 'tags.id', '=', 'post_tag.tag_id')
                                ->groupBy('tags.id')
                                ->select(['tags.*', DB::raw('COUNT(*) as cnt')])
                                ->orderBy('cnt', 'desc')
                                ->get();

        $view->with('latestposts', $posts);
        $view->with('latestvideos', $videos);
        $view->with('counttags', $counttags);
    }
}
